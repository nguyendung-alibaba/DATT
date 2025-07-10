<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'don_hang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ma_don_hang',
        'user_id',
        'ten_nguoi_nhan',
        'email',
        'so_dien_thoai',
        'dia_chi',
        'ghi_chu',
        'tong_tien',
        'giam_gia',
        'thanh_toan',
        'phuong_thuc_thanh_toan',
        'trang_thai',
        'ma_giam_gia',
        'ngay_dat',
        'ngay_xac_nhan',
        'ngay_giao_hang',
        'ngay_hoan_thanh',
        'stk_nguoi_nhan',
        'phuong_thuc_hoan',
        'ly_do_khieu_nai',
        'ngay_khieu_nai',
        'ngay_hoan_tien',
        'so_lan_giao_that_bai',

    ];

    protected $casts = [
        'tong_tien' => 'decimal:0',
        'giam_gia' => 'decimal:0',
        'thanh_toan' => 'decimal:0',
        'ngay_dat' => 'datetime',
        'ngay_xac_nhan' => 'datetime',
        'ngay_giao_hang' => 'datetime',
        'ngay_hoan_thanh' => 'datetime',
    ];

    // === Relationships ===
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chiTiet()
    {
        return $this->hasMany(DonHangChiTiet::class, 'don_hang_id');
    }

    public function voucher()
    {
        return $this->belongsTo(MaGiamGia::class, 'ma_giam_gia', 'ma_code');
    }

    // === Scopes ===
    public function scopePending($query)
    {
        return $query->where('trang_thai', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('trang_thai', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('trang_thai', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('trang_thai', 'cancelled');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('trang_thai', $status);
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('phuong_thuc_thanh_toan', $method);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('ngay_dat', [$startDate, $endDate]);
    }

    // === Accessors ===
    public function getTrangThaiTextAttribute()
    {
        return match ($this->trang_thai) {
            'pending'          => 'Chờ xác nhận',
            'confirmed'        => 'Đã xác nhận',
            'shipping'         => 'Đang giao hàng',
            'completed'        => 'Hoàn thành',
            'cancelled'        => 'Đã hủy',
            'failed'           => 'Giao thất bại',
            'returned'         => 'Đã trả về kho',
            'failed_returned'  => 'Đã nhận về kho',
            'complaint'     => 'Khiếu nại / Trả hàng',
            'refunded'      => 'Đã hoàn tiền',

            default            => 'Không xác định',
        };
    }

    public function getTrangThaiMauAttribute()
    {
        return match ($this->trang_thai) {
            'pending'          => 'warning',    // Vàng
            'confirmed'        => 'info',       // Xanh dương nhạt
            'shipping'         => 'primary',    // Xanh dương đậm
            'completed'        => 'success',    // Xanh lá
            'cancelled'        => 'danger',     // Đỏ
            'failed'           => 'danger',     // Đỏ
            'returned'         => 'dark',       // Đen/xám đậm
            'failed_returned'  => 'secondary',  // Xám nhạt
            'complaint'     => 'warning',    // Vàng
            'refunded'      => 'success',    // Xanh lá
            default            => 'secondary',  // Xám mặc định
        };
    }


    public function getPhuongThucThanhToanTextAttribute()
    {
        $methodMap = [
            'cod'         => 'Thanh toán khi nhận hàng (COD)',
            'vnpay'       => 'Thanh toán qua VNPay',
            'bank'        => 'Chuyển khoản ngân hàng',
            'credit_card' => 'Thẻ tín dụng'
        ];

        return $methodMap[$this->phuong_thuc_thanh_toan] ?? 'Không xác định';
    }

    public function getTongTienFormattedAttribute()
    {
        return number_format($this->tong_tien, 0, ',', '.') . '₫';
    }

    public function getGiamGiaFormattedAttribute()
    {
        return number_format($this->giam_gia, 0, ',', '.') . '₫';
    }

    public function getThanhToanFormattedAttribute()
    {
        return number_format($this->thanh_toan, 0, ',', '.') . '₫';
    }

    // === Helpers ===
    public function canCancel()
    {
        return in_array($this->trang_thai, ['pending', 'confirmed']);
    }

    public function isCompleted()
    {
        return $this->trang_thai === 'completed';
    }

    public function isPending()
    {
        return $this->trang_thai === 'pending';
    }

    public function isConfirmed()
    {
        return $this->trang_thai === 'confirmed';
    }
    public function getSoLanGiaoThatBaiTextAttribute()
    {
        return $this->so_lan_giao_that_bai . ' lần';
    }
    public function canGiaoLai()
    {
        return $this->trang_thai === 'failed' && ($this->so_lan_giao_that_bai < 2);
    }

    public function canNhanVeKho()
    {
        return $this->trang_thai === 'failed' && $this->so_lan_giao_that_bai >= 2;
    }
}
