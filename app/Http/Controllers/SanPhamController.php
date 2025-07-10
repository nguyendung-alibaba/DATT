<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\DanhMucSanPham;
use App\Models\SanPham;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\ThuongHieu;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SanPhamController extends Controller
{
    public function index()
    {
        $sanphams = SanPham::with(['danhMuc', 'thuongHieu', 'variants.color', 'variants.size'])->latest()->get();
        return view('admin.sanpham.index', compact('sanphams'));
    }

    public function create()
    {
        $danhmucs = DanhMucSanPham::all();
        $thuonghieus = ThuongHieu::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.sanpham.create', compact('danhmucs', 'thuonghieus', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        DB::beginTransaction();
        try {
            $productData = Arr::except($validatedData, ['image', 'variants', 'extra_images']);
            $productData['slug'] = $this->generateUniqueSlug($request->ten_san_pham);

            if ($request->hasFile('image')) {
                $productData['image'] = $this->handleImageUpload($request->file('image'), 'products');
            }

            $sanpham = SanPham::create($productData);

            $this->syncVariants($request, $sanpham);

            // Thêm ảnh phụ
            if ($request->hasFile('extra_images')) {
                foreach ($request->file('extra_images') as $image) {
                    $path = $this->handleImageUpload($image, 'products');
                    $sanpham->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();
            return redirect()->route('sanpham.index')->with('success', 'Đã thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($productData['image']) && Storage::disk('public')->exists($productData['image'])) {
                Storage::disk('public')->delete($productData['image']);
            }
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $sanpham = SanPham::with(['danhMuc', 'thuongHieu', 'variants.color', 'variants.size', 'images'])->findOrFail($id);
        return view('admin.sanpham.show', compact('sanpham'));
    }

    public function edit($id)
    {
        $sanpham = SanPham::with(['variants', 'images'])->findOrFail($id);
        $danhmucs = DanhMucSanPham::all();
        $thuonghieus = ThuongHieu::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.sanpham.edit', compact('sanpham', 'danhmucs', 'thuonghieus', 'colors', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRequest($request, $id);
        $sanpham = SanPham::findOrFail($id);

        DB::beginTransaction();
        try {
            $productData = Arr::except($validatedData, ['image', 'variants', 'extra_images']);

            if ($request->ten_san_pham !== $sanpham->ten_san_pham) {
                $productData['slug'] = $this->generateUniqueSlug($request->ten_san_pham, $id);
            }

            if ($request->hasFile('image')) {
                $productData['image'] = $this->handleImageUpload($request->file('image'), 'products', $sanpham->image);
            }
            $sanpham->update($productData);
            $this->syncVariants($request, $sanpham);

            // Xóa ảnh phụ cũ
            foreach ($sanpham->images as $img) {
                $this->deleteImage($img->image_path);
                $img->delete();
            }

            // Lưu ảnh phụ mới nếu có
            if ($request->hasFile('extra_images')) {
                foreach ($request->file('extra_images') as $image) {
                    $path = $this->handleImageUpload($image, 'products');
                    $sanpham->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();
            return redirect()->route('sanpham.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $sanpham = SanPham::with(['variants', 'images'])->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($sanpham->variants as $variant) {
                if ($variant->thumbnail) {
                    $this->deleteImage($variant->thumbnail);
                }
            }

            if ($sanpham->image) {
                $this->deleteImage($sanpham->image);
            }

            foreach ($sanpham->images as $img) {
                $this->deleteImage($img->image_path);
                $img->delete();
            }

            $sanpham->delete();

            DB::commit();
            return redirect()->route('sanpham.index')->with('success', 'Đã xóa sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }

    private function syncVariants(Request $request, SanPham $sanpham)
    {
        $existingVariantIds = $sanpham->variants->pluck('id')->toArray();
        $submittedVariantIds = [];

        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $variantId = $variantData['id'] ?? null;

                $dataForSync = Arr::except($variantData, ['id', 'thumbnail', 'current_thumbnail']);

                if (isset($variantData['thumbnail']) && $variantData['thumbnail'] instanceof UploadedFile) {
                    $oldThumbnail = $variantData['current_thumbnail'] ?? null;
                    $dataForSync['thumbnail'] = $this->handleImageUpload($variantData['thumbnail'], 'variants', $oldThumbnail);
                } elseif (isset($variantData['current_thumbnail'])) {
                    $dataForSync['thumbnail'] = $variantData['current_thumbnail'];
                }

                $variant = Variant::updateOrCreate(
                    ['id' => $variantId],
                    array_merge(['product_id' => $sanpham->product_id], $dataForSync)
                );

                $submittedVariantIds[] = $variant->id;
            }
        }

        $variantIdsToDelete = array_diff($existingVariantIds, $submittedVariantIds);
        if (!empty($variantIdsToDelete)) {
            $variantsToDelete = Variant::whereIn('id', $variantIdsToDelete)->get();
            foreach ($variantsToDelete as $variant) {
                if ($variant->thumbnail) {
                    $this->deleteImage($variant->thumbnail);
                }
                $variant->delete();
            }
        }
    }

    private function validateRequest(Request $request, $productId = null)
    {
        $rules = [
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:danh_muc_san_pham,category_id',
            'brand_id' => 'nullable|integer|exists:thuong_hieu,brand_id',
            'gia_ban' => 'required|numeric|min:0',
            'gia_goc' => 'nullable|numeric|min:0',
            'so_luong_ton' => 'nullable|integer|min:0',
            'mo_ta_ngan' => 'nullable|string|max:500',
            'mo_ta_chi_tiet' => 'nullable|string',
            'image' => ($productId ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'extra_images' => 'nullable|array',
            'extra_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'is_bestseller' => 'nullable|boolean',
            'trang_thai' => 'required|boolean',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|integer|exists:variants,id',
            'variants.*.color_id' => 'required_with:variants|integer|exists:colors,id',
            'variants.*.size_id' => 'required_with:variants|integer|exists:sizes,id',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'nullable|integer|min:0',
            'variants.*.thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        return $request->validate($rules);
    }

    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        $query = SanPham::where('slug', $slug);
        if ($excludeId) {
            $query->where('product_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count++;
            $query = SanPham::where('slug', $slug);
            if ($excludeId) {
                $query->where('product_id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    private function handleImageUpload(UploadedFile $file, string $folder, ?string $oldFilePath = null)
    {
        if ($oldFilePath) {
            $this->deleteImage($oldFilePath);
        }
        return $file->store($folder, 'public');
    }

    private function deleteImage(?string $filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
