<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaGiamGia;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        $vouchers = MaGiamGia::latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_code' => 'required|string|max:50|unique:MaGiamGia,ma_code',
            'ten_voucher' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'loai_giam_gia' => 'required|in:percentage,fixed_amount',
            'gia_tri_giam_gia' => 'required|numeric|min:0',
            'gia_tri_don_hang_toi_thieu' => 'nullable|numeric|min:0',
            'gia_tri_giam_toi_da' => 'nullable|numeric|min:0',
            'gioi_han_giam_co_dinh' => 'nullable|numeric|min:0',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'so_luong_gioi_han' => 'required|integer|min:1',
            'trang_thai' => 'required|in:active,inactive',
        ]);

        // ✅ Kiểm tra logic giảm cố định
        if ($validated['loai_giam_gia'] === 'fixed_amount') {
            if (empty($validated['gioi_han_giam_co_dinh'])) {
                return back()->withErrors([
                    'gioi_han_giam_co_dinh' => 'Vui lòng nhập giới hạn giảm cố định khi chọn giảm cố định.'
                ])->withInput();
            }

            if ($validated['gia_tri_giam_gia'] > $validated['gioi_han_giam_co_dinh']) {
                return back()->withErrors([
                    'gia_tri_giam_gia' => 'Giá trị giảm không được lớn hơn giới hạn giảm cố định.'
                ])->withInput();
            }
        }

        // ✅ Kiểm tra logic giữa giá trị giảm và đơn hàng tối thiểu
        if (!empty($validated['gia_tri_don_hang_toi_thieu'])) {
            if ($validated['gia_tri_giam_gia'] > $validated['gia_tri_don_hang_toi_thieu']) {
                return back()->withErrors([
                    'gia_tri_giam_gia' => 'Giá trị giảm không được lớn hơn giá trị đơn hàng tối thiểu.'
                ])->withInput();
            }

            $minRequiredDiscount = $validated['gia_tri_don_hang_toi_thieu'] * 0.05;
            if ($validated['gia_tri_giam_gia'] < $minRequiredDiscount) {
                return back()->withErrors([
                    'gia_tri_giam_gia' => 'Giá trị giảm nên lớn hơn tối thiểu 5% của đơn hàng tối thiểu (' . number_format($minRequiredDiscount, 0) . 'đ).'
                ])->withInput();
            }
        }

        $validated['so_luong_da_dung'] = 0;

        MaGiamGia::create($validated);

        return redirect()->route('ma-giam-gia.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function show($id)
    {
        $voucher = MaGiamGia::findOrFail($id);
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit($id)
    {
        $voucher = MaGiamGia::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = MaGiamGia::findOrFail($id);

        $validated = $request->validate([
            'ma_code' => 'required|string|max:50|unique:MaGiamGia,ma_code,' . $voucher->voucher_id . ',voucher_id',
            'ten_voucher' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'loai_giam_gia' => 'required|in:percentage,fixed_amount',
            'gia_tri_giam_gia' => 'required|numeric|min:0',
            'gia_tri_don_hang_toi_thieu' => 'nullable|numeric|min:0',
            'gia_tri_giam_toi_da' => 'nullable|numeric|min:0',
            'gioi_han_giam_co_dinh' => 'nullable|numeric|min:0',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'so_luong_gioi_han' => 'required|integer|min:1',
            'trang_thai' => 'required|in:active,inactive',
        ]);

        // ✅ Kiểm tra logic giảm cố định
        if ($validated['loai_giam_gia'] === 'fixed_amount') {
            if (empty($validated['gioi_han_giam_co_dinh'])) {
                return back()->withErrors([
                    'gioi_han_giam_co_dinh' => 'Vui lòng nhập giới hạn giảm cố định khi chọn giảm cố định.'
                ])->withInput();
            }

            if ($validated['gia_tri_giam_gia'] > $validated['gioi_han_giam_co_dinh']) {
                return back()->withErrors([
                    'gia_tri_giam_gia' => 'Giá trị giảm không được lớn hơn giới hạn giảm cố định.'
                ])->withInput();
            }
        }

        // ✅ Kiểm tra logic giữa giá trị giảm và đơn hàng tối thiểu
        if (!empty($validated['gia_tri_don_hang_toi_thieu'])) {
            if ($validated['gia_tri_giam_gia'] > $validated['gia_tri_don_hang_toi_thieu']) {
                return back()->withErrors([
                    'gia_tri_giam_gia' => 'Giá trị giảm không được lớn hơn giá trị đơn hàng tối thiểu.'
                ])->withInput();
            }

            $minRequiredDiscount = $validated['gia_tri_don_hang_toi_thieu'] * 0.05;
            if ($validated['gia_tri_giam_gia'] < $minRequiredDiscount) {
                return back()->withErrors([
                    'gia_tri_giam_gia' => 'Giá trị giảm nên lớn hơn tối thiểu 5% của đơn hàng tối thiểu (' . number_format($minRequiredDiscount, 0) . 'đ).'
                ])->withInput();
            }
        }

        $voucher->update($validated);

        return redirect()->route('ma-giam-gia.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        $voucher = MaGiamGia::findOrFail($id);
        $voucher->delete();

        return redirect()->route('ma-giam-gia.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
}
