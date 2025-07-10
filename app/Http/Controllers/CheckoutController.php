<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaGiamGia;
use App\Models\GioHang;
use App\Models\DonHang;
use App\Models\DonHangChiTiet;
use Illuminate\Support\Facades\Auth;
use App\Models\PhuongXa;
use App\Models\TinhThanh;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceivedMail;
use App\Models\UserProductView;
use App\Models\UserBehaviorLog;
use App\Models\OrderBlockchain;

class CheckoutController extends Controller
{
    protected function layGioHang()
    {
        $user = Auth::user();
        return GioHang::with('chiTiet.sanPham', 'chiTiet.variant.color', 'chiTiet.variant.size')->where(function ($q) use ($user) {
            $q->when($user, fn($q) => $q->where('user_id', $user->id))
                ->when(!$user, fn($q) => $q->where('session_id', session()->getId()));
        })->first();
    }

    public function show()
    {
        $gioHang = $this->layGioHang();
        $tongTien = $gioHang?->chiTiet->sum(fn($ct) => $ct->so_luong * $ct->don_gia) ?? 0;

        $discountCode = session('discount_code');
        $voucher = $discountCode ? MaGiamGia::where('ma_code', $discountCode)->first() : null;
        $giamGia = 0;

        if (!$voucher || !$voucher->isValid($tongTien)) {
            session()->forget(['discount_code', 'discount_amount', 'voucher_id']);
        } else {
            $giamGia = $voucher->getDiscountAmount($tongTien);
            session(['discount_amount' => $giamGia]);
        }

        $thanhToan = $tongTien - $giamGia;

        return view('client.checkout', compact('gioHang', 'tongTien', 'giamGia', 'discountCode', 'thanhToan', 'voucher'));
    }

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string'
        ]);

        $gioHang = $this->layGioHang();
        $tongTien = $gioHang?->chiTiet->sum(fn($ct) => $ct->so_luong * $ct->don_gia) ?? 0;

        if ($tongTien <= 0) {
            session()->forget(['discount_code', 'discount_amount', 'voucher_id']);
            return back()->withErrors(['discount_code' => 'Giỏ hàng của bạn đang trống.']);
        }

        $voucher = MaGiamGia::where('ma_code', $request->discount_code)->first();

        if (!$voucher) {
            return back()->withErrors(['discount_code' => 'Mã giảm giá không tồn tại.']);
        }

        if (session('discount_code') === $voucher->ma_code) {
            return back()->with('discount_success', 'Mã đã được áp dụng trước đó.');
        }

        if (!$voucher->isValid($tongTien)) {
            return back()->withErrors(['discount_code' => $voucher->getInvalidReason($tongTien)]);
        }

        $giamGia = $voucher->getDiscountAmount($tongTien);

        session([
            'discount_code' => $voucher->ma_code,
            'discount_amount' => $giamGia,
            'voucher_id' => $voucher->voucher_id,
        ]);

        return back()->with('discount_success', 'Áp mã giảm giá thành công!');
    }

    public function removeDiscount()
    {
        session()->forget(['discount_code', 'discount_amount', 'voucher_id']);
        return back()->with('discount_success', 'Đã hủy mã giảm giá.');
    }

    public function paymentForm()
    {
        $gioHang = $this->layGioHang();
        $dsTinhThanh = \App\Models\TinhThanh::all();


        if (!$gioHang || $gioHang->chiTiet->isEmpty()) {
            return redirect()->route('checkout.show')->withErrors(['checkout' => 'Giỏ hàng của bạn đang trống.']);
        }

        $tongTien = $gioHang->chiTiet->sum(fn($ct) => $ct->so_luong * $ct->don_gia);
        $giamGia = 0;
        $voucher = null;

        if (session('discount_code')) {
            $voucher = MaGiamGia::where('ma_code', session('discount_code'))->first();
            if ($voucher && $voucher->isValid($tongTien)) {
                $giamGia = $voucher->getDiscountAmount($tongTien);
                session(['discount_amount' => $giamGia]);
            } else {
                session()->forget(['discount_code', 'discount_amount', 'voucher_id']);
            }
        }

        $thanhToan = $tongTien - $giamGia;

        return view('client.payment', compact('gioHang', 'tongTien', 'giamGia', 'thanhToan', 'dsTinhThanh'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'so_nha' => 'required|string|max:255',
            'phuong_xa_id' => 'required|exists:phuong_xa,id',
            'so_dien_thoai' => 'required|string|regex:/^[0-9]{10,11}$/',
            'phuong_thuc' => 'required|in:cod,vnpay',
            'ghi_chu' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $gioHang = $this->layGioHang();

            if (!$gioHang || $gioHang->chiTiet->isEmpty()) {
                return back()->withErrors(['checkout' => 'Giỏ hàng rỗng!']);
            }

            $tongTien = $gioHang->chiTiet->sum(fn($ct) => $ct->so_luong * $ct->don_gia);
            $giamGia = session('discount_amount', 0);
            $thanhToan = $tongTien - $giamGia;

            $xa = PhuongXa::with('tinhThanh')->find($request->phuong_xa_id);
            if (!$xa) {
                return back()->withErrors(['phuong_xa_id' => 'Không tìm thấy phường/xã.']);
            }
            $diaChi = $request->so_nha . ', ' . $xa->ten_phuong_xa . ', ' . $xa->tinhThanh->ten_tinh;

            $maDonHang = 'DH' . date('YmdHis') . rand(100, 999);

            $donHang = DonHang::create([
                'ma_don_hang' => $maDonHang,
                'user_id' => $user->id,
                'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
                'email' => $request->email,
                'so_dien_thoai' => $request->so_dien_thoai,
                'dia_chi' => $diaChi,
                'ghi_chu' => $request->ghi_chu,
                'tong_tien' => $tongTien,
                'giam_gia' => $giamGia,
                'thanh_toan' => $thanhToan,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc,
                'trang_thai' => 'pending',
                'ma_giam_gia' => session('discount_code'),
                'ngay_dat' => now(),
                'phuong_xa_id' => $xa->id,
                'tinh_id' => $xa->tinhThanh->id,
            ]);

            foreach ($gioHang->chiTiet as $ct) {
                DonHangChiTiet::create([
                    'don_hang_id' => $donHang->id,
                    'product_id' => $ct->product_id,
                    'variant_id' => $ct->variant_id,
                    'ten_san_pham' => $ct->sanPham->ten_san_pham,
                    'so_luong' => $ct->so_luong,
                    'don_gia' => $ct->don_gia,
                    'thanh_tien' => $ct->so_luong * $ct->don_gia,
                ]);

                // Ghi nhận hành vi checkout
                UserBehaviorLog::create([
                    'user_id' => $user->id,
                    'session_id' => session()->getId(),
                    'product_id' => $ct->product_id,
                    'action' => 'checkout',
                ]);

                // Tăng điểm score +5 cho sản phẩm được mua
                UserProductView::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'session_id' => $user ? null : session()->getId(),
                        'product_id' => $ct->product_id,
                    ],
                    [
                        'score' => DB::raw('score + 5')
                    ]
                );
            }

            if ($request->phuong_thuc === 'vnpay') {
                session(['pending_order_id' => $donHang->id]);
                DB::commit();
                return $this->createVNPayPayment($donHang);
            } else {
                // Tạo block blockchain cho đơn hàng pending
                OrderBlockchain::createBlock($donHang->id);

                // Xóa giỏ hàng & session giảm giá
                $user = Auth::user();
                $gioHang = GioHang::where('user_id', $user->id)->first();
                if ($gioHang) {
                    $gioHang->chiTiet()->delete();
                    $gioHang->delete();
                }
                session()->forget(['discount_code', 'discount_amount', 'voucher_id']);

                DB::commit();
                return redirect()->route('checkout.success', ['order' => $donHang->ma_don_hang])
                    ->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $maDonHang);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['checkout' => 'Lỗi khi xử lý đơn hàng: ' . $e->getMessage()]);
        }
    }



    // public function paymentSuccess($orderCode = null)
    // {
    //     $donHang = null;

    //     if ($orderCode) {
    //         $donHang = DonHang::with(['chiTiet.sanPham', 'chiTiet.variant.color', 'chiTiet.variant.size'])
    //             ->where('ma_don_hang', $orderCode)
    //             ->first();
    //     }

    //     return view('client.payment-success', compact('donHang'));
    // }


    // tích hợp gửi mail vào trong paymentSuccess thong báo khi đặt hàng

    // xoa gio hang sau khi thanh toán thành công

    protected function xoaGioHangSauDatHang()
    {
        $user = Auth::user();
        $gioHang = GioHang::where('user_id', $user->id)->first();
        if ($gioHang) {
            $gioHang->chiTiet()->delete();
            $gioHang->delete();
        }

        session()->forget(['discount_code', 'discount_amount', 'voucher_id']);
    }

    public function paymentSuccess($orderCode = null)
    {
        $donHang = null;
        $dsTinhThanh = \App\Models\TinhThanh::all();

        if ($orderCode) {
            $donHang = DonHang::with(['chiTiet.sanPham', 'chiTiet.variant.color', 'chiTiet.variant.size'])
                ->where('ma_don_hang', $orderCode)
                ->first();

            // GỬI MAIL 
            if ($donHang && $donHang->email) {
                try {
                    Mail::to($donHang->email)->send(new OrderReceivedMail($donHang));
                } catch (\Exception $e) {
                    \Log::error('Lỗi gửi mail xác nhận đơn hàng: ' . $e->getMessage());
                }
            }
        }

        return view('client.payment-success', compact('donHang', 'dsTinhThanh'));
    }



    protected function createVNPayPayment($donHang)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = env('VNPAY_TMN_CODE', 'VNPAY_TMN_CODE'); // Mã website tại VNPAY
        $vnp_HashSecret = env('VNPAY_HASH_SECRET', 'VNPAY_HASH_SECRET'); // Chuỗi bí mật

        $vnp_TxnRef = $donHang->ma_don_hang; // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $donHang->ma_don_hang;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $donHang->thanh_toan * 100; // VNPay yêu cầu số tiền * 100
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASH_SECRET', 'VNPAY_HASH_SECRET');
        $inputData = array();
        $returnData = array();

        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            $orderId = session('pending_order_id');

            if ($inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                if ($orderId) {
                    $this->completeOrder($orderId);
                    session()->forget('pending_order_id');
                }

                return redirect()->route('checkout.success', ['order' => $inputData['vnp_TxnRef']])
                    ->with('success', 'Thanh toán thành công! Mã đơn hàng: ' . $inputData['vnp_TxnRef']);
            } else {
                // Thanh toán thất bại
                if ($orderId) {
                    DonHang::find($orderId)->update(['trang_thai' => 'failed']);
                    session()->forget('pending_order_id');
                }

                return redirect()->route('checkout.payment')->withErrors(['checkout' => 'Thanh toán thất bại. Vui lòng thử lại.']);
            }
        } else {
            return redirect()->route('home')->withErrors(['checkout' => 'Có lỗi xảy ra trong quá trình xác thực thanh toán.']);
        }
    }

    protected function completeOrder($orderId)
    {
        DB::beginTransaction();

        try {
            $donHang = DonHang::findOrFail($orderId);

            // Cập nhật trạng thái đơn hàng
            $donHang->update([
                'trang_thai' => 'confirmed',
                'ngay_xac_nhan' => now(),
            ]);
            \App\Models\OrderBlockchain::createBlock($donHang->id);
            // Cập nhật số lượng đã sử dụng voucher
            if ($donHang->ma_giam_gia) {
                $voucher = MaGiamGia::where('ma_code', $donHang->ma_giam_gia)->first();
                if ($voucher) {
                    $voucher->increment('so_luong_da_dung');
                }
            }

            // Xóa giỏ hàng
            $user = Auth::user();
            $gioHang = GioHang::where('user_id', $user->id)->first();
            if ($gioHang) {
                $gioHang->chiTiet()->delete();
                $gioHang->delete();
            }

            // Xóa session mã giảm giá
            session()->forget(['discount_code', 'discount_amount', 'voucher_id']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
