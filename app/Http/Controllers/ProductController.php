<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\Variant;
use App\Models\UserProductView;
use App\Models\UserBehaviorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $datas = SanPham::with('images')->get();
        $products = [];

        foreach ($datas as $data) {
            $badge = null;
            if ($data->gia_goc && $data->gia_goc > $data->gia_ban) {
                $badge = 'Sale';
            }

            $images = [$data->image];
            if ($data->images && $data->images->count() > 0) {
                foreach ($data->images as $img) {
                    $images[] = $img->image_path;
                }
            }

            $products[] = [
                'id' => $data->product_id,
                'name' => $data->ten_san_pham,
                'price' => $data->gia_ban,
                'original_price' => $data->gia_goc,
                'image' => $data->image,
                'images' => $images,
                'slug' => $data->slug,
                'category_id' => $data->danh_muc_san_pham,
                'brand_id' => $data->thuongHieu,
                'rating' => round(rand(35, 50) / 10, 1),
                'reviews' => rand(100, 1000),
                'features' => ['Màn hình OLED', 'Camera 48MP', 'Thiết kế cao cấp'],
                'badge' => $badge,
                'description' => $data->mo_ta_chi_tiet ?? 'Chưa có mô tả chi tiết cho sản phẩm này.',
                'price_after_discount' => $data->gia_ban,
                'discount' => ($data->gia_goc && $data->gia_goc > $data->gia_ban)
                    ? round((($data->gia_goc - $data->gia_ban) / $data->gia_goc) * 100)
                    : 0,
            ];
        }

        $featuredProducts = array_slice($products, 0, 4);
        $recommended = $this->getRecommendedProducts(20);

        return view('client.sanpham.home', compact('products', 'featuredProducts', 'recommended'));
    }

    public function show($slug)
    {
        $sanPham = SanPham::with(['variants.color', 'variants.size', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Ghi nhận hành vi xem sản phẩm (AI behavior)
        $userId = Auth::id();
        $sessionId = session()->getId();

        UserBehaviorLog::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'product_id' => $sanPham->product_id,
            'action' => 'view',
        ]);

        // Ghi điểm cho hành vi view (+1)
        UserProductView::updateOrCreate(
            [
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $sanPham->product_id,
                'action' => 'view',
            ],
            [
                'score' => DB::raw('score + 1')
            ]
        );

        $images = [$sanPham->image];
        if ($sanPham->images && $sanPham->images->count() > 0) {
            foreach ($sanPham->images as $img) {
                $images[] = $img->image_path;
            }
        }

        $product = [
            'product_id' => $sanPham->product_id,
            'name' => $sanPham->ten_san_pham,
            'image' => $sanPham->image,
            'images' => $images,
            'rating' => round(rand(35, 50) / 10, 1),
            'price_after_discount' => $sanPham->gia_ban,
            'original_price' => $sanPham->gia_goc,
            'discount' => ($sanPham->gia_goc && $sanPham->gia_goc > $sanPham->gia_ban)
                ? round(abs($sanPham->gia_goc - $sanPham->gia_ban) / $sanPham->gia_goc * 100)
                : 0,
            'description' => $sanPham->mo_ta_chi_tiet ?? 'Chưa có mô tả chi tiết cho sản phẩm này.',
            'variants' => $sanPham->variants,
        ];

        $relatedProducts = SanPham::with('images')
            ->where('category_id', $sanPham->danh_muc_san_pham)
            ->where('product_id', '!=', $sanPham->product_id)
            ->limit(4)
            ->get();

        $transformedRelatedProducts = [];
        foreach ($relatedProducts as $data) {
            $badge = null;
            if ($data->gia_goc && $data->gia_goc > $data->gia_ban) {
                $badge = 'Sale';
            }

            $relatedImages = [$data->image];
            if ($data->images && $data->images->count() > 0) {
                foreach ($data->images as $img) {
                    $relatedImages[] = $img->image_path;
                }
            }

            $transformedRelatedProducts[] = [
                'id' => $data->product_id,
                'name' => $data->ten_san_pham,
                'price' => $data->gia_ban,
                'original_price' => $data->gia_goc,
                'image' => $data->image,
                'images' => $relatedImages,
                'slug' => $data->slug,
                'category_id' => $data->danh_muc_san_pham,
                'brand_id' => $data->thuongHieu,
                'rating' => round(rand(35, 50) / 10, 1),
                'reviews' => rand(100, 1000),
                'features' => ['Màn hình OLED', 'Camera 48MP', 'Thiết kế cao cấp'],
                'badge' => $badge,
            ];
        }

        return view('client.sanpham.show', compact('product', 'transformedRelatedProducts'));
    }

    protected function getRecommendedProducts($limit = 4)
    {
        $user = Auth::user();
        $sessionId = session()->getId();

        $query = UserProductView::select('product_id', DB::raw('SUM(score) as total_score'))
            ->where(function ($q) use ($user, $sessionId) {
                $user ? $q->where('user_id', $user->id) : $q->where('session_id', $sessionId);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_score')
            ->take($limit)
            ->pluck('product_id');

        return SanPham::with('images')->whereIn('product_id', $query)->get();
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:san_pham,product_id'],
            'variant_id' => [
                'required',
                Rule::exists('variants', 'id')->where(fn($query) => $query->where('product_id', $request->product_id)),
            ],
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $sessionId = session()->getId();

        // Ghi hành vi add_to_cart
        UserBehaviorLog::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'product_id' => $request->product_id,
            'action' => 'add_to_cart',
        ]);

        // Ghi điểm cho hành vi add_to_cart (+3)
        UserProductView::updateOrCreate(
            [
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $request->product_id,
                'action' => 'add_to_cart',
            ],
            [
                'score' => DB::raw('score + 3')
            ]
        );

        $sanPham = SanPham::where('product_id', $request->product_id)->first();
        if (!$sanPham || $sanPham->trang_thai == 0) {
            Log::warning('Cố gắng thêm sản phẩm không hợp lệ', ['product_id' => $request->product_id]);
            return back()->withErrors(['product_id' => 'Sản phẩm đã ngừng kinh doanh.'])->withInput();
        }

        $variant = Variant::where('id', $request->variant_id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$variant || $variant->trang_thai == 0) {
            Log::warning('Biến thể không hợp lệ hoặc đã bị tắt', [
                'variant_id' => $request->variant_id,
                'product_id' => $request->product_id,
            ]);
            return back()->withErrors(['variant_id' => 'Biến thể không hợp lệ hoặc đã bị tắt.'])->withInput();
        }

        if ($variant->so_luong < $request->quantity) {
            return back()->withErrors(['quantity' => 'Không đủ số lượng tồn kho.'])->withInput();
        }

        // TODO: Xử lý thêm vào giỏ hàng

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
}
