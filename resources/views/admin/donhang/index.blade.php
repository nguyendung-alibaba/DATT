@extends('admin.layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<h3>Danh sách đơn hàng</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã ĐH</th>
            <th>Người nhận</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donHangs as $donHang)
        <tr>
            <td>{{ $donHang->ma_don_hang }}</td>
            <td>{{ $donHang->ten_nguoi_nhan }}</td>
            <td>{{ $donHang->thanh_toan_formatted }}</td>
            <td>
                <span class="badge bg-{{ $donHang->trang_thai_mau }}">
                    {{ $donHang->trang_thai_text }}
                </span>
                <br>
                @if ($donHang->so_lan_giao_that_bai > 0)
                <small class="text-muted">Số lần giao thất bại: {{ $donHang->so_lan_giao_that_bai }}</small>
                @endif
            </td>
            <td>{{ $donHang->ngay_dat->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('don-hang.show', $donHang->id) }}" class="btn btn-sm btn-info">Chi tiết</a>

                <form action="{{ route('don-hang.destroy', $donHang->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa đơn hàng này?')">Xóa</button>
                </form>

                {{-- Xác nhận --}}
                @if ($donHang->trang_thai === 'pending')
                <form action="{{ route('donhang.confirm', $donHang->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-success" onclick="return confirm('Xác nhận đơn hàng này?')">Xác nhận</button>
                </form>
                @endif

                {{-- Giao hàng --}}
                @if ($donHang->trang_thai === 'confirmed')
                <form action="{{ route('donhang.giaohang', $donHang->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-warning" onclick="return confirm('Chuyển sang giao hàng?')">Giao hàng</button>
                </form>
                @endif

                {{-- Giao lại nếu thất bại < 2 --}}
                @if ($donHang->trang_thai === 'confirmed' && $donHang->so_lan_giao_that_bai > 0 && $donHang->so_lan_giao_that_bai < 2)
                    <form action="{{ route('donhang.giaohang', $donHang->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-warning" onclick="return confirm('Giao lại đơn hàng?')">Giao lại</button>
                    </form>
                    @endif

                    {{-- Giao thất bại và hoàn thành khi đang giao --}}
                    {{-- Giao thất bại --}}
                    @if ($donHang->trang_thai === 'shipping')
                    <form action="{{ route('donhang.trahang', $donHang->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-secondary" onclick="return confirm('Xử lý giao hàng thất bại?')">Giao thất bại</button>
                    </form>
                    @endif

                    {{-- Khi trạng thái là thất bại (failed) và có thể nhận hàng về kho hoặc huỷ --}}
                    @if ($donHang->trang_thai === 'failed')
                    <form action="{{ route('donhang.nhanve', $donHang->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-dark" onclick="return confirm('Xác nhận nhận hàng về kho?')">Nhận về kho</button>
                    </form>

                    <form action="{{ route('donhang.huy', $donHang->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xác nhận hủy đơn?')">Hủy đơn</button>
                    </form>
                    @endif


                    {{-- Hủy khi chưa giao --}}
                    @if (in_array($donHang->trang_thai, ['pending', 'confirmed']))
                    <form action="{{ route('donhang.huy', $donHang->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hủy đơn hàng này?')">Hủy đơn</button>
                    </form>
                    @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $donHangs->links() }}
@endsection