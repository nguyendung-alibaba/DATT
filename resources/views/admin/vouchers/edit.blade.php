@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card với Gradient -->
            <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3 me-3">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">Chỉnh Sửa Mã Giảm Giá</h3>
                                <p class="mb-0 opacity-90">
                                    <span class="badge bg-white bg-opacity-20 px-3 py-2 fs-6">
                                        <i class="bi bi-tag me-2"></i>{{ $voucher->ma_code }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('ma-giam-gia.show', $voucher->voucher_id) }}" class="btn btn-light btn-lg shadow-sm">
                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-20 rounded-circle p-2 me-3">
                                    <i class="bi bi-exclamation-triangle text-danger"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>Oops! Có lỗi xảy ra</strong>
                                    <p class="mb-0 mt-1">Vui lòng kiểm tra lại các thông tin bên dưới:</p>
                                </div>
                            </div>
                            <ul class="mb-0 mt-3 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li class="py-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('ma-giam-gia.update', $voucher->voucher_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Thông tin cơ bản -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-primary mb-1">
                                    <i class="bi bi-info-circle me-2"></i>Thông tin cơ bản
                                </h5>
                                <div class="border-bottom border-primary" style="width: 60px; height: 3px;"></div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="ma_code" id="ma_code" class="form-control border-2" value="{{ old('ma_code', $voucher->ma_code) }}" placeholder="VD: SALE2024" required>
                                        <label for="ma_code">Mã giảm giá <span class="text-danger">*</span></label>
                                        <div class="form-text">
                                            <i class="bi bi-key me-1"></i>Mã duy nhất để áp dụng giảm giá
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="ten_voucher" id="ten_voucher" class="form-control border-2" value="{{ old('ten_voucher', $voucher->ten_voucher) }}" placeholder="VD: Giảm giá mùa hè" required>
                                        <label for="ten_voucher">Tên voucher <span class="text-danger">*</span></label>
                                        <div class="form-text">
                                            <i class="bi bi-tag me-1"></i>Tên hiển thị của mã giảm giá
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="form-floating">
                                    <textarea name="mo_ta" id="mo_ta" class="form-control border-2" style="height: 100px" placeholder="Mô tả chi tiết về mã giảm giá này">{{ old('mo_ta', $voucher->mo_ta) }}</textarea>
                                    <label for="mo_ta">Mô tả chi tiết</label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Cấu hình giảm giá -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-success mb-1">
                                    <i class="bi bi-calculator me-2"></i>Cấu hình giảm giá
                                </h5>
                                <div class="border-bottom border-success" style="width: 60px; height: 3px;"></div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="loai_giam_gia" class="form-label fw-semibold">
                                        Loại giảm giá <span class="text-danger">*</span>
                                    </label>
                                    <select name="loai_giam_gia" id="loai_giam_gia" class="form-select border-2" required>
                                        <option value="percentage" {{ old('loai_giam_gia', $voucher->loai_giam_gia) === 'percentage' ? 'selected' : '' }}>
                                            💯 Phần trăm (%)
                                        </option>
                                        <option value="fixed_amount" {{ old('loai_giam_gia', $voucher->loai_giam_gia) === 'fixed_amount' ? 'selected' : '' }}>
                                            💰 Giảm cố định (VNĐ)
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" name="gia_tri_giam_gia" id="gia_tri_giam_gia" class="form-control border-2" value="{{ old('gia_tri_giam_gia', $voucher->gia_tri_giam_gia) }}" required>
                                        <label for="gia_tri_giam_gia">Giá trị giảm <span class="text-danger">*</span></label>
                                        <div class="form-text">
                                            <i class="bi bi-percent me-1"></i>VD: 10 (%) hoặc 50000 (VNĐ)
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" name="gia_tri_don_hang_toi_thieu" id="gia_tri_don_hang_toi_thieu" class="form-control border-2" value="{{ old('gia_tri_don_hang_toi_thieu', $voucher->gia_tri_don_hang_toi_thieu) }}">
                                        <label for="gia_tri_don_hang_toi_thieu">Đơn hàng tối thiểu</label>
                                        <div class="form-text">
                                            <i class="bi bi-cart me-1"></i>Giá trị đơn hàng tối thiểu để áp dụng
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="discount-limit-fields">
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="number" step="0.01" name="gia_tri_giam_toi_da" id="gia_tri_giam_toi_da" class="form-control border-2" value="{{ old('gia_tri_giam_toi_da', $voucher->gia_tri_giam_toi_da) }}">
                                                <label for="gia_tri_giam_toi_da">Giá trị giảm tối đa</label>
                                                <div class="form-text">
                                                    <i class="bi bi-shield-check me-1"></i>Áp dụng khi giảm theo phần trăm
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="number" step="0.01" name="gioi_han_giam_co_dinh" id="gioi_han_giam_co_dinh" class="form-control border-2" value="{{ old('gioi_han_giam_co_dinh', $voucher->gioi_han_giam_co_dinh) }}">
                                                <label for="gioi_han_giam_co_dinh">Giới hạn giảm cố định</label>
                                                <div class="form-text">
                                                    <i class="bi bi-shield-check me-1"></i>Giới hạn cho giảm cố định (tuỳ chọn)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Thời gian áp dụng -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-warning mb-1">
                                    <i class="bi bi-clock me-2"></i>Thời gian áp dụng
                                </h5>
                                <div class="border-bottom border-warning" style="width: 60px; height: 3px;"></div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="datetime-local" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control border-2" value="{{ old('ngay_bat_dau', \Carbon\Carbon::parse($voucher->ngay_bat_dau)->format('Y-m-d\TH:i')) }}" required>
                                        <label for="ngay_bat_dau">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="datetime-local" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control border-2" value="{{ old('ngay_ket_thuc', \Carbon\Carbon::parse($voucher->ngay_ket_thuc)->format('Y-m-d\TH:i')) }}" required>
                                        <label for="ngay_ket_thuc">Ngày kết thúc <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Cài đặt nâng cao -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-info mb-1">
                                    <i class="bi bi-gear me-2"></i>Cài đặt nâng cao
                                </h5>
                                <div class="border-bottom border-info" style="width: 60px; height: 3px;"></div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="so_luong_gioi_han" id="so_luong_gioi_han" class="form-control border-2" value="{{ old('so_luong_gioi_han', $voucher->so_luong_gioi_han) }}" min="1" required>
                                        <label for="so_luong_gioi_han">Số lượng giới hạn <span class="text-danger">*</span></label>
                                        <div class="form-text">
                                            <i class="bi bi-people me-1"></i>Số lần tối đa mã có thể được sử dụng
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="trang_thai" class="form-label fw-semibold">
                                        Trạng thái <span class="text-danger">*</span>
                                    </label>
                                    <select name="trang_thai" id="trang_thai" class="form-select border-2" required>
                                        <option value="active" {{ old('trang_thai', $voucher->trang_thai) === 'active' ? 'selected' : '' }}>
                                            ✅ Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('trang_thai', $voucher->trang_thai) === 'inactive' ? 'selected' : '' }}>
                                            ⏸️ Tạm ngưng
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-top pt-4">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('ma-giam-gia.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-warning btn-lg px-4 shadow-sm text-white">
                                    <i class="bi bi-arrow-repeat me-2"></i>Cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loaiGiamGia = document.getElementById('loai_giam_gia');
        const giamToiDaGroup = document.querySelector('[name="gia_tri_giam_toi_da"]').closest('.mb-3');
        const giamCoDinhGroup = document.querySelector('[name="gioi_han_giam_co_dinh"]').closest('.mb-3');

        function toggleFields() {
            const value = loaiGiamGia.value;
            if (value === 'percentage') {
                giamToiDaGroup.style.display = 'block';
                giamCoDinhGroup.style.display = 'none';
            } else if (value === 'fixed_amount') {
                giamToiDaGroup.style.display = 'none';
                giamCoDinhGroup.style.display = 'block';
            }
        }

        toggleFields();
        loaiGiamGia.addEventListener('change', toggleFields);

        // Thêm hiệu ứng focus cho form floating
        const floatingInputs = document.querySelectorAll('.form-floating input, .form-floating textarea');
        floatingInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
</script>

<style>
.form-section {
    position: relative;
}

.section-header {
    position: relative;
}

.form-floating.focused {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}

.card {
    transition: all 0.3s ease;
}

.alert {
    border-radius: 12px;
}

.form-control,
.form-select {
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.section-header h5 {
    color: #2c3e50;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.border-2 {
    border-width: 2px !important;
}

.discount-limit-fields .mb-3:last-child {
    margin-bottom: 0 !important;
}

.btn-warning.text-white {
    background: linear-gradient(45deg, #ff9f43, #feca57);
    border: none;
}

.btn-warning.text-white:hover {
    background: linear-gradient(45deg, #ff8c1a, #fd9644);
}
</style>
@endsection