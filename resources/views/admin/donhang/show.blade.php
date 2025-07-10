@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<h3>Chi tiết đơn hàng: {{ $donHang->ma_don_hang }}</h3>

<p>Người nhận: {{ $donHang->ten_nguoi_nhan }} | SĐT: {{ $donHang->so_dien_thoai }}</p>
<p>Địa chỉ: {{ $donHang->dia_chi }} | Email: {{ $donHang->email }}</p>

@php
$paymentMap = [
'cod' => 'Thanh toán khi nhận hàng (COD)',
'vnpay' => 'Thanh toán qua VNPay',
'bank' => 'Chuyển khoản ngân hàng',
'credit_card' => 'Thẻ tín dụng'
];

$badgeClasses = [
'Chờ xác nhận' => 'badge bg-warning text-dark',
'Đã xác nhận' => 'badge bg-primary',
'Đang giao hàng' => 'badge bg-info',
'Hoàn thành' => 'badge bg-success',
'Đã hủy' => 'badge bg-danger',
'Thất bại' => 'badge bg-secondary',
];

$badgeClass = $badgeClasses[$donHang->trang_thai] ?? 'badge bg-light text-dark';
@endphp

<p>Phương thức thanh toán:
    <span class="badge bg-light text-dark">
        {{ $paymentMap[$donHang->phuong_thuc_thanh_toan] ?? 'Không xác định' }}
    </span>
</p>

<p>Ghi chú: {{ $donHang->ghi_chu }}</p>
<p>Trạng thái: <span class="{{ $badgeClass }}">{{ $donHang->trang_thai }}</span></p>
{{-- Thông tin khiếu nại --}}
@if ($donHang->ly_do_khieu_nai)
<div class="alert alert-warning mt-3">
    <h5 class="mb-2">📢 Khiếu nại đã gửi</h5>
    <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::parse($donHang->ngay_khieu_nai)->format('d/m/Y H:i') }}</p>
    <p><strong>Lý do:</strong> {{ $donHang->ly_do_khieu_nai }}</p>
</div>
@endif

{{-- Thông tin hoàn tiền --}}
@if ($donHang->ngay_hoan_tien)
<div class="alert alert-info mt-3">
    <h5 class="mb-2">💸 Đơn hàng đã hoàn tiền</h5>
    <p><strong>Phương thức hoàn tiền:</strong> {{ strtoupper($donHang->phuong_thuc_hoan) }}</p>
    @if ($donHang->stk_nguoi_nhan)
    <p><strong>Số tài khoản nhận:</strong> {{ $donHang->stk_nguoi_nhan }}</p>
    @endif
    <p><strong>Thời gian hoàn tiền:</strong> {{ \Carbon\Carbon::parse($donHang->ngay_hoan_tien)->format('d/m/Y H:i') }}</p>
</div>
@endif

<h4>Sản phẩm:</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên SP</th>
            <th>Biến thể</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donHang->chiTiet as $ct)
        <tr>
            <td>{{ $ct->ten_san_pham }}</td>
            <td>{{ $ct->variant?->color?->ten_mau ?? '' }} / {{ $ct->variant?->size?->ten_size ?? '' }}</td>
            <td>{{ $ct->so_luong }}</td>
            <td>{{ number_format($ct->don_gia) }}đ</td>
            <td>{{ number_format($ct->thanh_tien) }}đ</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if ($donHang->trang_thai === 'Chờ xác nhận')
<form method="POST" action="{{ route('donhang.confirm', $donHang->id) }}">
    @csrf
    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận đơn hàng này?')">Xác nhận đơn hàng</button>
</form>
@endif

<a href="{{ route('don-hang.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
<p><strong>Số lần giao thất bại:</strong> {{ $donHang->so_lan_giao_that_bai }}</p>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any custom JavaScript here if needed
    });
</script>
@endsection