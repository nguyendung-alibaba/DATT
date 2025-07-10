@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Mã Giảm Giá</h1>
        <a href="{{ route('ma-giam-gia.create') }}" class="btn btn-primary d-inline-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i> Thêm Mã Giảm Giá Mới
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Mã Giảm Giá hiện có</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã Giảm Giá</th>
                            <th>Tên Voucher</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Thời gian áp dụng</th>
                            <th>Lượt dùng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $v)
                            @php
                                $now = \Carbon\Carbon::now();
                                $ketThuc = \Carbon\Carbon::parse($v->ngay_ket_thuc);
                                $isExpired = $ketThuc->isPast();
                                $isExpiringSoon = !$isExpired && $ketThuc->diffInDays($now) <= 3;
                            @endphp
                            <tr>
                                <td>{{ $v->voucher_id }}</td>
                                <td><span class="badge bg-info text-dark">{{ $v->ma_code }}</span></td>
                                <td>{{ $v->ten_voucher }}</td>
                                <td>
                                    @if ($v->loai_giam_gia == 'percentage')
                                        <span class="badge bg-primary">Phần trăm (%)</span>
                                    @else
                                        <span class="badge bg-success">Giảm cố định (VNĐ)</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($v->loai_giam_gia == 'percentage')
                                        {{ $v->gia_tri_giam_gia }}%
                                        @if ($v->gia_tri_giam_toi_da)
                                            <br><small class="text-muted">(Tối đa {{ number_format($v->gia_tri_giam_toi_da, 0, ',', '.') }}đ)</small>
                                        @endif
                                    @else
                                        {{ number_format($v->gia_tri_giam_gia, 0, ',', '.') }}đ
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($v->ngay_bat_dau)->format('d/m/Y H:i') }} - <br>
                                    {{ \Carbon\Carbon::parse($v->ngay_ket_thuc)->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    @if ($v->so_luong_da_dung > $v->so_luong_gioi_han)
                                        <span class="text-danger fw-bold">{{ $v->so_luong_da_dung }} / {{ $v->so_luong_gioi_han }}</span>
                                    @else
                                        {{ $v->so_luong_da_dung }} / {{ $v->so_luong_gioi_han }}
                                    @endif
                                </td>
                                <td>
                                    @if ($v->trang_thai == 'active')
                                        @if ($isExpired)
                                            <span class="badge bg-danger">Hết hạn</span>
                                        @elseif ($isExpiringSoon)
                                            <span class="badge bg-warning text-dark">Sắp hết hạn</span>
                                        @else
                                            <span class="badge bg-success">Kích hoạt</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Tạm ngưng</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Thao tác">
                                        <a href="{{ route('ma-giam-gia.show', $v->voucher_id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('ma-giam-gia.edit', $v->voucher_id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="POST" action="{{ route('ma-giam-gia.destroy', $v->voucher_id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Không có mã giảm giá nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $vouchers->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Khởi tạo tooltips của Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection
