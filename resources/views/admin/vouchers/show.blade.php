@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết Mã Giảm Giá: <span class="text-primary">{{ $voucher->ma_code }}</span></h1>
        <a href="{{ route('ma-giam-gia.index') }}" class="btn btn-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Thông tin chi tiết Voucher</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Mã Giảm Giá:</strong> <span class="badge bg-info text-dark">{{ $voucher->ma_code }}</span></p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Tên Voucher:</strong> {{ $voucher->ten_voucher }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <p class="mb-2"><strong>Mô tả:</strong> {{ $voucher->mo_ta ?? '(Không có mô tả)' }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Loại giảm giá:</strong>
                        @if ($voucher->loai_giam_gia === 'percentage')
                            <span class="badge bg-primary">Phần trăm (%)</span>
                        @else
                            <span class="badge bg-success">Giảm cố định (VNĐ)</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Giá trị giảm:</strong>
                        @if ($voucher->loai_giam_gia === 'percentage')
                            <span class="text-success fw-bold">{{ $voucher->gia_tri_giam_gia }}%</span>
                        @else
                            <span class="text-success fw-bold">{{ number_format($voucher->gia_tri_giam_gia, 0, ',', '.') }}đ</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Đơn hàng tối thiểu:</strong> <span class="fw-bold">{{ number_format($voucher->gia_tri_don_hang_toi_thieu, 0, ',', '.') }}đ</span></p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Đơn hàng tối đa:</strong>
                        @if ($voucher->gia_tri_giam_toi_da)
                            <span class="fw-bold">{{ number_format($voucher->gia_tri_giam_toi_da, 0, ',', '.') }}đ</span>
                        @else
                            <span class="text-muted">(Không giới hạn)</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <p class="mb-2"><strong>Thời gian áp dụng:</strong>
                        <span class="fw-bold">
                            Từ {{ \Carbon\Carbon::parse($voucher->ngay_bat_dau)->format('H:i d/m/Y') }}
                            đến {{ \Carbon\Carbon::parse($voucher->ngay_ket_thuc)->format('H:i d/m/Y') }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Số lượng giới hạn:</strong> <span class="fw-bold">{{ $voucher->so_luong_gioi_han }} lượt</span></p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Đã dùng:</strong> <span class="fw-bold">{{ $voucher->so_luong_da_dung }} lượt</span></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <p class="mb-2"><strong>Trạng thái:</strong>
                        <span class="badge bg-{{ $voucher->trang_thai === 'active' ? 'success' : 'secondary' }}">
                            {{ $voucher->trang_thai === 'active' ? 'Kích hoạt' : 'Tạm ngưng' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end"> {{-- Căn phải các nút --}}
        <a href="{{ route('ma-giam-gia.edit', $voucher->voucher_id) }}" class="btn btn-warning d-inline-flex align-items-center me-2">
            <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa
        </a>
        <form method="POST" action="{{ route('ma-giam-gia.destroy', $voucher->voucher_id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không?');" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger d-inline-flex align-items-center">
                <i class="bi bi-trash me-2"></i> Xóa
            </button>
        </form>
    </div>
</div>
@endsection