<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MaGiamGia extends Model
{
    protected $table = 'magiamgia';
    protected $primaryKey = 'voucher_id';

    protected $fillable = [
        'ma_code',
        'ten_voucher',
        'mo_ta',
        'loai_giam_gia',
        'gia_tri_giam_gia',
        'gia_tri_don_hang_toi_thieu',
        'gia_tri_giam_toi_da',
        'gioi_han_giam_co_dinh',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'so_luong_gioi_han',
        'so_luong_da_dung',
        'trang_thai',
    ];

    /**
     * Kiểm tra mã giảm giá có hợp lệ hay không
     */
    public function isValid($tongTien)
    {
        $now = now();

        return $this->trang_thai === 'active'
            && $this->so_luong_da_dung < $this->so_luong_gioi_han
            && $this->ngay_bat_dau <= $now
            && $this->ngay_ket_thuc >= $now
            && $tongTien >= $this->gia_tri_don_hang_toi_thieu;
    }

    /**
     * Trả về lý do tại sao mã không hợp lệ
     */
    public function getInvalidReason($tongTien)
    {
        $now = now();

        if ($this->trang_thai !== 'active') {
            return 'Mã này đã bị vô hiệu hóa.';
        }

        if ($this->so_luong_da_dung >= $this->so_luong_gioi_han) {
            return 'Mã giảm giá đã được sử dụng hết.';
        }

        if ($this->ngay_bat_dau > $now) {
            return 'Mã này chưa được bắt đầu.';
        }

        if ($this->ngay_ket_thuc < $now) {
            return 'Mã này đã hết hạn.';
        }

        if ($tongTien < $this->gia_tri_don_hang_toi_thieu) {
            return 'Đơn hàng chưa đủ giá trị tối thiểu để áp dụng mã.';
        }

        return 'Mã không hợp lệ hoặc không đủ điều kiện.';
    }

    /**
     * Tính số tiền được giảm
     */
    public function getDiscountAmount($tongTien)
    {
        if ($this->loai_giam_gia === 'percentage') {
            $giam = round($tongTien * $this->gia_tri_giam_gia / 100);
            return min($giam, $this->gia_tri_giam_toi_da ?? $giam);
        }

        // fixed_amount
        return min($this->gia_tri_giam_gia, $this->gioi_han_giam_co_dinh ?? $this->gia_tri_giam_gia, $tongTien);
    }
}
