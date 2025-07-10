<?php
// app/Http/Controllers/VariantController.php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\BienTheSanPham;
use App\Models\ThuocTinh;
use App\Models\GiaTriThuocTinh;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    // Thêm biến thể (form)
    public function create($product_id)
    {
        $sanpham = SanPham::findOrFail($product_id);
        // Lấy các thuộc tính dùng cho biến thể
        $attributes = ThuocTinh::where('is_variant_attribute', true)
            ->with('values')->get();
        return view('variant.create', compact('sanpham', 'attributes'));
    }

    // Lưu biến thể
    public function store(Request $request, $product_id)
    {
        $sanpham = SanPham::findOrFail($product_id);

        $validated = $request->validate([
            'ma_sku' => 'required|unique:bien_the_san_pham,ma_sku',
            'gia_ban' => 'required|numeric',
            'so_luong_ton' => 'required|integer',
            'attributes' => 'required|array'
        ]);

        $bienThe = $sanpham->bienThe()->create([
            'ma_sku' => $request->ma_sku,
            'gia_ban' => $request->gia_ban,
            'so_luong_ton' => $request->so_luong_ton,
            'trang_thai' => 'active',
        ]);

        // Gắn thuộc tính cho biến thể
        foreach ($request->attributes as $attribute_id => $attribute_value_id) {
            $bienThe->chiTiet()->create([
                'attribute_value_id' => $attribute_value_id
            ]);
        }

        return redirect()->route('sanpham.show', $sanpham->product_id)
            ->with('success', 'Thêm biến thể thành công!');
    }

    // Sửa biến thể (form)
    public function edit($variant_id)
    {
        $bienThe = BienTheSanPham::with('sanPham')->findOrFail($variant_id);
        $attributes = ThuocTinh::where('is_variant_attribute', true)->with('values')->get();

        // Lấy attribute_value_id hiện tại của biến thể
        $selectedAttributes = $bienThe->chiTiet()->pluck('attribute_value_id', 'attribute_id')->toArray();

        return view('variant.edit', compact('bienThe', 'attributes', 'selectedAttributes'));
    }

    // Cập nhật biến thể
    public function update(Request $request, $variant_id)
    {
        $bienThe = BienTheSanPham::findOrFail($variant_id);

        $validated = $request->validate([
            'ma_sku' => 'required|unique:bien_the_san_pham,ma_sku,'.$variant_id.',variant_id',
            'gia_ban' => 'required|numeric',
            'so_luong_ton' => 'required|integer',
            'attributes' => 'required|array'
        ]);

        $bienThe->update([
            'ma_sku' => $request->ma_sku,
            'gia_ban' => $request->gia_ban,
            'so_luong_ton' => $request->so_luong_ton,
        ]);

        // Cập nhật lại thuộc tính biến thể
        $bienThe->chiTiet()->delete();
        foreach ($request->attributes as $attribute_id => $attribute_value_id) {
            $bienThe->chiTiet()->create([
                'attribute_value_id' => $attribute_value_id
            ]);
        }

        return redirect()->route('sanpham.show', $bienThe->product_id)
            ->with('success', 'Cập nhật biến thể thành công!');
    }

    // Xóa biến thể
    public function destroy($variant_id)
    {
        $bienThe = BienTheSanPham::findOrFail($variant_id);
        $product_id = $bienThe->product_id;
        $bienThe->delete();

        return redirect()->route('sanpham.show', $product_id)
            ->with('success', 'Đã xóa biến thể!');
    }
}