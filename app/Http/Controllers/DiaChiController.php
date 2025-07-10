<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhuongXa;
use App\Models\TinhThanh;

class DiaChiController extends Controller
{
    // ✅ API: /api/phuong-xa?tinh_id=1
    public function getPhuongXa(Request $request)
    {
        $tinhId = $request->query('tinh_id');

        if (!$tinhId) {
            return response()->json([
                'message' => 'Thiếu tham số tinh_id'
            ], 400);
        }

        $dsPhuongXa = PhuongXa::where('ma_tinh', $tinhId)->get(['id', 'ten_phuong_xa']);
        return response()->json($dsPhuongXa);
    }

    // ✅ API: /api/tinh-thanh
    public function getTinhThanh()
    {
        $dsTinhThanh = TinhThanh::all(['id', 'ten_tinh']);
        return response()->json($dsTinhThanh);
    }

    // ✅ API: /api/tinh-thanh/{id}/phuong-xa
    public function getPhuongXaTheoTinh($id)
    {
        $tinh = TinhThanh::find($id);

        if (!$tinh) {
            return response()->json(['message' => 'Không tìm thấy tỉnh/thành'], 404);
        }

        $phuongXa = $tinh->phuongXa()->get(['id', 'ten_phuong_xa']);

        return response()->json([
            'tinh' => $tinh->ten_tinh,
            'phuong_xa' => $phuongXa
        ]);
    }
}
