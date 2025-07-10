<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GioHang;
use App\Models\ChiTietGioHang;
use App\Models\SanPham;
use App\Models\Variant;

class CartController extends Controller
{
    /**
     * Lấy hoặc tạo giỏ hàng cho user hoặc khách
     */
    protected function getOrCreateCart()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return GioHang::firstOrCreate([
            'user_id'    => $userId,
            'session_id' => $userId ? null : $sessionId,
        ]);
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $cart = $this->getOrCreateCart();
        $items = ChiTietGioHang::where('cart_id', $cart->cart_id)
            ->with(['product', 'variant.color', 'variant.size'])
            ->get();

        $tong_tien = $items->sum(function ($item) {
            return $item->don_gia * $item->so_luong;
        });

        return view('client.cart.index', compact('items', 'tong_tien'));
    }

    /**
     * Thêm sản phẩm vào giỏ
     */
public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:san_pham,product_id', // Kiểm tra lại tên bảng: 'san_phams' hay 'san_pham'?
            'variant_id' => 'nullable|exists:variants,id', // 'nullable' cho phép variant_id là null nếu không có biến thể
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $product = SanPham::findOrFail($request->product_id);

        $productId = $product->product_id;
        // Lấy variant_id từ request. Nếu không có, nó sẽ là null.
        $variantId = $request->variant_id;

        $donGia = $product->gia_ban; // Mặc định giá sản phẩm chính

        // Nếu có variant_id được gửi lên
        if ($variantId) {
            // Tìm biến thể và kiểm tra xem nó có thuộc sản phẩm này không
            // Tải sẵn color và size ngay tại đây để có thể sử dụng nếu cần
            $variant = Variant::with(['color', 'size'])
                ->where('id', $variantId)
                ->where('product_id', $productId)
                ->first();

            if (!$variant) {
                // Nếu biến thể không tồn tại hoặc không thuộc sản phẩm này,
                // có thể báo lỗi hoặc quyết định không thêm dưới dạng biến thể.
                // Hiện tại, chúng ta sẽ báo lỗi để đảm bảo tính đúng đắn.
                return back()->withErrors(['variant_id' => 'Biến thể không hợp lệ hoặc không thuộc sản phẩm này.'])
                             ->withInput(); // Giữ lại dữ liệu đã nhập
            }
            // Lấy giá từ biến thể. Đảm bảo tên cột `price` (hoặc `gia_ban`) khớp với database của bạn.
            $donGia = $variant->price ?? $product->gia_ban;
            // Nếu bạn dùng cột 'gia_ban' trong model Variant, thì dùng:
            // $donGia = $variant->gia_ban ?? $product->gia_ban;
        }

        // Tìm mục trong giỏ hàng. QUAN TRỌNG: Tìm theo cả product_id và variant_id
        // Nếu variant_id là NULL, nó sẽ khớp với các mục không có biến thể.
        // Nếu variant_id có giá trị, nó sẽ khớp với mục có biến thể cụ thể đó.
        $item = ChiTietGioHang::where('cart_id', $cart->cart_id)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId) // KHẮC PHỤC CHÍNH Ở ĐÂY: Sử dụng $variantId để tìm đúng mục
            ->first();

        if ($item) {
            $item->so_luong += $request->quantity;
            $item->updated_at = now();
            $item->save();
            $message = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!';
        } else {
            // Tạo mới ChiTietGioHang nếu chưa tồn tại
            $cart->chiTietGioHang()->create([
                'product_id' => $productId,
                'variant_id' => $variantId, // KHẮC PHỤC CHÍNH Ở ĐÂY: Đảm bảo variant_id được lưu
                'so_luong'   => $request->quantity,
                'don_gia'    => $donGia,
                'status'     => 'active',
                'selected'   => true,
            ]);
            $message = 'Đã thêm sản phẩm vào giỏ hàng!';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }


    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'so_luong' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $item = ChiTietGioHang::where('cart_id', $cart->cart_id)
            ->where('cart_item_id', $id)
            ->firstOrFail();

        $item->so_luong = $request->so_luong;
        $item->updated_at = now();
        $item->save();

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ
     */
    public function destroy($id)
    {
        $cart = $this->getOrCreateCart();
        $item = ChiTietGioHang::where('cart_id', $cart->cart_id)
            ->where('cart_item_id', $id)
            ->firstOrFail();

        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        ChiTietGioHang::where('cart_id', $cart->cart_id)->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
    /**
     * Cập nhật số lượng hàng loạt trong giỏ hàng
     */
    public function updateAll(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();

        foreach ($request->quantities as $cartItemId => $quantity) {
            $item = ChiTietGioHang::where('cart_id', $cart->cart_id)
                ->where('cart_item_id', $cartItemId)
                ->first();

            if ($item) {
                $item->so_luong = $quantity;
                $item->updated_at = now();
                $item->save();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng thành công!');
    }
}
