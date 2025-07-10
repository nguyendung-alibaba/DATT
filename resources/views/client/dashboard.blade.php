@extends('client.layouts.app')

@section('title', 'Dashboard của tôi')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Xin chào, {{ Auth::user()->name }} 👋</h2>

    <div class="row g-4">
        <!-- Tổng đơn hàng -->
        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tổng đơn hàng</h5>
                    <p class="fs-3 text-primary">{{ $tongDonHang }}</p>
                </div>
            </div>
        </div>

        <!-- Tổng sản phẩm trong giỏ -->
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm trong giỏ</h5>
                    <p class="fs-3 text-success">{{ $tongSanPhamTrongGio }}</p>
                </div>
            </div>
        </div>

        <!-- Sản phẩm yêu thích -->
        <div class="col-md-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm yêu thích</h5>
                    <p class="fs-3 text-warning">{{ $yeuThichCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <h4>Đơn hàng gần đây</h4>
    @if ($donHangGanDay->isEmpty())
        <p>Chưa có đơn hàng nào.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover mt-3">
                <thead class="table-light">
                    <tr>
                        <th>#Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donHangGanDay as $donHang)
                        <tr>
                            <td>{{ $donHang->id }}</td>
                            <td>{{ $donHang->created_at->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($donHang->trang_thai) }}</td>
                            <td>{{ number_format($donHang->tong_tien, 0, ',', '.') }} đ</td>
                            <td>
                                <a href="{{ route('client.orders.show', $donHang->id) }}" class="btn btn-sm btn-info">Xem</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
