@extends('client.layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Đơn hàng của tôi</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($donHangs->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donHangs as $donHang)
                        <tr>
                            <td>{{ $donHang->ma_don_hang }}</td>
                            <td>{{ $donHang->ngay_dat->format('d/m/Y H:i') }}</td>
                            <td>{{ $donHang->thanh_toan_formatted }}</td>
                            <td>
                                <span class="badge bg-{{ $donHang->trang_thai_mau }}">
                                    {{ $donHang->trang_thai_text }}
                                </span>
                            </td>
                            <td>
                                {{-- Xem chi tiết --}}
                                <a href="{{ route('client.donhang.show', $donHang->id) }}" class="btn btn-sm btn-info mb-1">
                                    Chi tiết
                                </a>

                                {{-- Đã nhận hàng (chỉ nếu đang giao) --}}
                                @if ($donHang->trang_thai === 'shipping')
                                    <form action="{{ route('client.donhang.nhanhang', $donHang->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-success mb-1" onclick="return confirm('Xác nhận đã nhận hàng?')">
                                            Đã nhận hàng
                                        </button>
                                    </form>
                                @endif

                                {{-- Khiếu nại / Trả hàng (chỉ khi đã hoàn thành và chưa khiếu nại) --}}
                                @if ($donHang->trang_thai === 'completed' && !$donHang->ly_do_khieu_nai)
                                    <a href="{{ route('donhang.khieunai', $donHang->id) }}" class="btn btn-sm btn-warning mb-1">
                                        Khiếu nại / Trả hàng
                                    </a>
                                @endif

                                {{-- Hủy đơn (nếu đang chờ xác nhận) --}}
                                @if ($donHang->trang_thai === 'pending')
                                    <form action="{{ route('donhang.huy', $donHang->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger mb-1" onclick="return confirm('Bạn có chắc muốn hủy đơn này?')">
                                            Hủy đơn
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Phân trang --}}
            {{ $donHangs->links() }}
        </div>
    @endif
</div>
@endsection