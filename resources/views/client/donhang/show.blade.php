@extends('client.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Chi tiết đơn hàng #{{ $donHang->ma_don_hang }}</h3>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <p><strong>Trạng thái:</strong>
            <span class="badge bg-{{ 
                $donHang->trang_thai == 'pending' ? 'secondary' :
                ($donHang->trang_thai == 'confirmed' ? 'primary' :
                ($donHang->trang_thai == 'shipping' ? 'info' :
                ($donHang->trang_thai == 'completed' ? 'success' :
                ($donHang->trang_thai == 'cancelled' ? 'danger' : 'warning')))) 
            }}">
                {{ ucfirst(__($donHang->trang_thai)) }}
            </span>
        </p>
        <p><strong>Ngày đặt:</strong> {{ $donHang->ngay_dat->format('d/m/Y H:i') }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $donHang->phuong_thuc_thanh_toan_text }}</p>
        <p><strong>Địa chỉ:</strong> {{ $donHang->dia_chi }}</p>
        <p><strong>Ghi chú:</strong> {{ $donHang->ghi_chu ?? 'Không có' }}</p>

        {{-- Thông tin khiếu nại --}}
        @if ($donHang->ly_do_khieu_nai)
        <div class="alert alert-warning mt-3">
            <h5 class="mb-2">📢 Khiếu nại đã gửi</h5>
            <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::parse($donHang->ngay_khieu_nai)->format('d/m/Y H:i') }}</p>
            <p><strong>Lý do:</strong> {{ $donHang->ly_do_khieu_nai }}</p>
        </div>
        @endif

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

    </div>

    {{-- Chi tiết sản phẩm --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên SP</th>
                <th>Biến thể</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
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

    <div class="mt-3">
        <p><strong>Tổng cộng:</strong> {{ $donHang->thanh_toan_formatted }}</p>
    </div>

    {{-- Các nút thao tác --}}
    <div class="mt-4">
        {{-- Đang giao hàng -> cho xác nhận hoặc khiếu nại --}}
        @if ($donHang->trang_thai === 'shipping')
        <form action="{{ route('client.donhang.hoanThanh', $donHang->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận bạn đã nhận được hàng?')">
                Tôi đã nhận được hàng
            </button>
        </form>
        @endif

        {{-- Đơn đã hoàn thành -> cho gửi khiếu nại --}}
        @if ($donHang->trang_thai === 'completed' && !$donHang->ly_do_khieu_nai)
        <a href="{{ route('donhang.khieunai', $donHang->id) }}" class="btn btn-warning">Khiếu nại / Trả hàng</a>
        @endif

        {{-- Chờ xác nhận hoặc đã xác nhận -> cho huỷ --}}
        @if (in_array($donHang->trang_thai, ['pending', 'confirmed']))
        <form action="{{ route('donhang.huy', $donHang->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                Hủy đơn hàng
            </button>
        </form>
        @endif
    </div>

    <a href="{{ route('client.donhang.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection