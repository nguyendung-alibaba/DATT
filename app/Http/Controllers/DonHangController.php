<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderBlockchain;
use Illuminate\Support\Facades\Log;

class DonHangController extends Controller
{
    // ===================== ADMIN =====================

    public function index()
    {
        $donHangs = DonHang::latest()->paginate(20);
        return view('admin.donhang.index', compact('donHangs'));
    }

    public function show($id)
    {
        $donHang = DonHang::with('chiTiet', 'user')->findOrFail($id);
        return view('admin.donhang.show', compact('donHang'));
    }

    public function xacNhan($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'pending') {
            return back()->with('error', 'Không thể xác nhận đơn hàng này.');
        }

        $donHang->update([
            'trang_thai' => 'confirmed',
            'ngay_xac_nhan' => now(),
        ]);
        // Ghi nhận blockchain đơn hàng
        try {
            $latestBlock = OrderBlockchain::latest()->first();

            $previousHash = $latestBlock?->current_hash ?? 'GENESIS';
            $data = json_encode($donHang->toArray());

            $currentHash = hash('sha256', $data . $previousHash);

            OrderBlockchain::create([
                'don_hang_id' => $donHang->id,
                'data' => $data,
                'previous_hash' => $previousHash,
                'current_hash' => $currentHash,
            ]);
        } catch (\Exception $e) {
            Log::error('Blockchain error: ' . $e->getMessage());
        }


        return back()->with('success', 'Đã xác nhận đơn hàng.');
    }

    public function giaoHang($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'confirmed') {
            return back()->with('error', 'Chỉ có thể giao hàng với đơn đã xác nhận.');
        }

        $donHang->update([
            'trang_thai' => 'shipping',
            'ngay_giao_hang' => now(),
        ]);

        return back()->with('success', 'Đơn hàng đang được giao.');
    }

    public function hoanThanh($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'shipping') {
            return back()->with('error', 'Chỉ có thể hoàn thành đơn đang giao.');
        }

        $donHang->update([
            'trang_thai' => 'completed',
            'ngay_hoan_thanh' => now(),
        ]);

        return back()->with('success', 'Đơn hàng đã hoàn thành.');
    }

    public function traHang($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'shipping') {
            return back()->with('error', 'Chỉ xử lý trả hàng khi đơn đang giao.');
        }

        // Tăng số lần thất bại
        $donHang->so_lan_giao_that_bai += 1;

        if ($donHang->so_lan_giao_that_bai >= 2) {
            // Quá 2 lần -> Trả về kho
            $donHang->trang_thai = 'returned';
        } else {
            // Chỉ thất bại 1 lần -> vẫn cho phép giao lại
            $donHang->trang_thai = 'confirmed'; // quay về trạng thái đã xác nhận
        }

        $donHang->save();

        return back()->with('success', 'Xử lý trạng thái giao hàng thất bại thành công.');
    }



    public function huyDon($id)
    {
        $donHang = DonHang::findOrFail($id);

        // Chỉ được hủy nếu chưa giao hàng
        if (!in_array($donHang->trang_thai, ['pending', 'confirmed'])) {
            return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
        }

        $donHang->update(['trang_thai' => 'cancelled']);

        return back()->with('success', 'Đã hủy đơn hàng.');
    }
    public function nhanVeKho($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'failed') {
            return back()->with('error', 'Chỉ có thể nhận về kho khi đơn ở trạng thái giao hàng thất bại.');
        }

        $donHang->update([
            'trang_thai' => 'failed_returned',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Đơn hàng đã được chuyển về kho.');
    }



    public function destroy($id)
    {
        $donHang = DonHang::findOrFail($id);
        $donHang->delete();

        return redirect()->route('don-hang.index')->with('success', 'Đã xóa đơn hàng.');
    }
    public function giaoThatBai($id)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'shipping') {
            return back()->with('error', 'Chỉ có thể đánh dấu thất bại khi đang giao hàng.');
        }

        $soLan = $donHang->so_lan_giao_that_bai + 1;

        if ($soLan >= 2) {
            $donHang->update([
                'trang_thai' => 'returned',
                'so_lan_giao_that_bai' => $soLan,
            ]);
            // Tùy chọn: gọi hàm chuyển về kho ở đây
            return back()->with('error', 'Đã quá 2 lần giao thất bại. Đơn hàng đã chuyển về kho.');
        }

        $donHang->update([
            'so_lan_giao_that_bai' => $soLan,
        ]);

        return back()->with('error', 'Đã ghi nhận giao hàng thất bại lần ' . $soLan);
    }


    // ===================== CLIENT =====================

    public function clientIndex()
    {
        $donHangs = DonHang::where('user_id', Auth::id())->latest()->paginate(10);
        return view('client.donhang.index', compact('donHangs'));
    }

    public function clientShow($id)
    {
        $donHang = DonHang::where('user_id', Auth::id())
            ->with([
                'chiTiet.variant.color',
                'chiTiet.variant.size'
            ])
            ->findOrFail($id);

        return view('client.donhang.show', compact('donHang'));
    }

    public function hoanThanhClient($id)
    {
        $donHang = DonHang::where('user_id', Auth::id())
            ->where('trang_thai', 'shipping')
            ->findOrFail($id);

        $donHang->update([
            'trang_thai' => 'completed',
            'ngay_hoan_thanh' => now(),
        ]);

        return back()->with('success', 'Đã xác nhận đã nhận hàng.');
    }

    public function huyClient($id)
    {
        $donHang = DonHang::where('user_id', Auth::id())->findOrFail($id);

        if ($donHang->trang_thai !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xác nhận.');
        }

        $donHang->update(['trang_thai' => 'cancelled']);

        return back()->with('success', 'Đơn hàng đã được hủy.');
    }
    public function khieuNaiTraHangClient($id, Request $request)
    {
        $donHang = DonHang::where('user_id', Auth::id())
            ->where('trang_thai', 'shipping')
            ->findOrFail($id);

        $donHang->update([
            'trang_thai' => 'complaint',
            'ly_do_khieu_nai' => $request->ly_do ?? 'Không rõ',
            'ngay_khieu_nai' => now(),
        ]);

        return back()->with('success', 'Đã ghi nhận khiếu nại. Bộ phận hỗ trợ sẽ xử lý sớm nhất.');
    }
    public function hoanTien($id, Request $request)
    {
        $donHang = DonHang::findOrFail($id);

        if ($donHang->trang_thai !== 'complaint') {
            return back()->with('error', 'Đơn hàng không ở trạng thái khiếu nại.');
        }

        $donHang->update([
            'trang_thai' => 'refunded',
            'ngay_hoan_tien' => now(),
            'phuong_thuc_hoan' => $request->phuong_thuc,
            'stk_nguoi_nhan' => $request->stk,
        ]);

        return back()->with('success', 'Đã xử lý hoàn tiền cho khách.');
    }
    public function xacNhanHoanThanh($id)
    {
        $donHang = DonHang::findOrFail($id);
        if ($donHang->trang_thai === 'shipping') {
            $donHang->update([
                'trang_thai' => 'completed',
                'ngay_hoan_thanh' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Xác nhận hoàn thành thành công!');
    }
    public function formKhieuNai($id)
    {
        $donHang = DonHang::findOrFail($id);
        return view('client.donhang.khieunai', compact('donHang'));
    }
    public function submitKhieuNai(Request $request, $id)
    {
        $request->validate([
            'ly_do_khieu_nai' => 'required|string|max:255',
            'phuong_thuc_hoan' => 'nullable|string|max:50',
            'stk_nguoi_nhan' => 'nullable|string|max:50',
        ]);

        $donHang = DonHang::findOrFail($id);
        $donHang->update([
            'trang_thai' => 'failed',
            'ly_do_khieu_nai' => $request->ly_do_khieu_nai,
            'ngay_khieu_nai' => now(),
            'phuong_thuc_hoan' => $request->phuong_thuc_hoan,
            'stk_nguoi_nhan' => $request->stk_nguoi_nhan,
            'ngay_hoan_tien' => now(), // Nếu bạn muốn auto xử lý
        ]);

        return redirect()->route('client.donhang.show', $id)->with('success', 'Khiếu nại đã được gửi.');
    }
    public function kiemTraBlockchain()
    {
        $blocks = OrderBlockchain::orderBy('id')->get();

        $valid = true;
        $prevHash = 'GENESIS';

        foreach ($blocks as $block) {
            $expectedHash = hash('sha256', $block->data . $prevHash);
            if ($block->current_hash !== $expectedHash) {
                $valid = false;
                break;
            }
            $prevHash = $block->current_hash;
        }

        return view('admin.blockchain.check', compact('valid', 'blocks'));
    }
}
