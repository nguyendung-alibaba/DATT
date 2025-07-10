@extends('client.layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="checkout-header mb-4">
                <div class="d-flex align-items-center">
                    <div class="checkout-icon me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 text-primary fw-bold">Xác nhận đơn hàng</h2>
                        <p class="text-muted mb-0">Kiểm tra thông tin trước khi thanh toán</p>
                    </div>
                </div>
            </div>

            {{-- Thông báo --}}
            @if(session('discount_success'))
            <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('discount_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if ($errors->has('discount_code'))
            <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first('discount_code') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card product-card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fas fa-list me-2 text-primary"></i>
                                Sản phẩm trong giỏ hàng
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if ($gioHang && $gioHang->chiTiet->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 modern-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 ps-4">Sản phẩm</th>
                                            <th class="border-0 text-center">Giá</th>
                                            <th class="border-0 text-center">Số lượng</th>
                                            <th class="border-0 text-end pe-4">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gioHang->chiTiet as $ct)
                                        <tr class="product-row">
                                            <td class="ps-4 py-3">
                                                <div class="product-info">
                                                    <h6 class="mb-0 fw-semibold">{{ $ct->sanPham->ten_san_pham ?? 'Không xác định' }}</h6>
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="price-text">{{ number_format($ct->don_gia) }}₫</span>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="quantity-badge">{{ $ct->so_luong }}</span>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <span class="total-price fw-bold">{{ number_format($ct->don_gia * $ct->so_luong) }}₫</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="empty-cart text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Không có sản phẩm nào trong giỏ hàng</h5>
                                <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    @if (!$discountCode)
                    <div class="card discount-card shadow-sm mb-4">
                        <div class="card-header bg-gradient-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-percent me-2"></i>
                                Mã giảm giá
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('checkout.applyDiscount') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="discount_code" class="form-label fw-semibold">Nhập mã giảm giá</label>
                                    <div class="input-group discount-input">
                                        <span class="input-group-text">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <input type="text"
                                            name="discount_code"
                                            id="discount_code"
                                            class="form-control"
                                            value="{{ old('discount_code') }}"
                                            placeholder="VD: SALE20, FREESHIP..."
                                            required>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-check me-1"></i>Áp dụng
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="card summary-card shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fas fa-calculator me-2 text-success"></i>
                                Tổng kết đơn hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="summary-item d-flex justify-content-between mb-3">
                                <span class="text-secondary">Tạm tính:</span>
                                <span class="fw-semibold">{{ number_format($tongTien) }}₫</span>
                            </div>

                            @if ($giamGia > 0)
                            <div class="discount-info mb-3 p-3 rounded" style="background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%); border-left: 4px solid #28a745;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-tag text-success me-2"></i>
                                            <strong class="text-success">Mã giảm giá: {{ $discountCode }}</strong>
                                        </div>
                                        <div class="discount-amount text-success fw-bold mb-2">
                                            -{{ number_format($giamGia) }}₫
                                        </div>

                                        @if(isset($voucher))
                                        @if($voucher->mo_ta)
                                        <small class="text-muted d-block mb-1">{{ $voucher->mo_ta }}</small>
                                        @endif

                                        @php
                                        \Carbon\Carbon::setLocale('vi');
                                        $ketThuc = \Carbon\Carbon::parse($voucher->ngay_ket_thuc);
                                        @endphp
                                        <small class="text-success d-block">
                                            <i class="fas fa-clock me-1"></i>
                                            Hiệu lực đến: {{ $ketThuc->format('H:i d/m/Y') }} ({{ $ketThuc->diffForHumans() }})
                                        </small>
                                        @endif
                                    </div>

                                    <form action="{{ route('checkout.removeDiscount') }}" method="POST" class="ms-2">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger rounded-circle"
                                            onclick="return confirm('Bạn có chắc chắn muốn hủy mã này không?')"
                                            title="Hủy mã giảm giá">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif

                            <hr class="my-3">

                            <div class="summary-total d-flex justify-content-between mb-4">
                                <span class="fs-5 fw-bold text-primary">Tổng thanh toán:</span>
                                <span class="fs-4 fw-bold text-danger">{{ number_format($thanhToan) }}₫</span>
                            </div>

                            <div class="action-buttons">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                                    <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                                </a>
                                {{-- Changed from <button> to <a> and added the route --}}
                                <a href="{{ route('checkout.payment') }}" class="btn btn-success btn-lg w-100 checkout-btn">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Tiến hành thanh toán
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 15px;
        color: white;
        margin-bottom: 2rem;
    }

    .checkout-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .custom-alert {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .product-card,
    .discount-card,
    .summary-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .product-card:hover,
    .discount-card:hover,
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .modern-table {
        font-size: 0.95rem;
    }

    .product-row {
        transition: background-color 0.2s ease;
    }

    .product-row:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .price-text {
        color: #6c757d;
        font-weight: 500;
    }

    .quantity-badge {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .total-price {
        color: #28a745;
        font-size: 1.1rem;
    }

    .empty-cart {
        color: #6c757d;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }

    .discount-input .input-group-text {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border: 1px solid #ced4da;
        color: #495057;
    }

    .discount-input .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .discount-input .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        padding: 0.5rem 1rem;
    }

    .summary-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .summary-item:last-of-type {
        border-bottom: none;
    }

    .summary-total {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1rem;
        border-radius: 10px;
        border: 2px solid #007bff;
    }

    .checkout-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #20c997, #28a745);
    }

    .action-buttons .btn-outline-secondary {
        border: 2px solid #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .action-buttons .btn-outline-secondary:hover {
        background: #6c757d;
        transform: translateY(-1px);
    }

    @media (max-width: 991.98px) {
        .checkout-header {
            text-align: center;
            padding: 1.5rem;
        }

        .checkout-icon {
            margin: 0 auto 1rem;
        }

        .col-lg-4 {
            margin-top: 2rem;
        }
    }

    @media (max-width: 767.98px) {
        .container-fluid {
            padding: 0 15px;
        }

        .modern-table {
            font-size: 0.85rem;
        }

        .modern-table th,
        .modern-table td {
            padding: 0.5rem !important;
        }

        .quantity-badge {
            padding: 2px 8px;
            font-size: 0.75rem;
        }
    }
</style>

{{-- Auto focus --}}
@if (!$discountCode)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const discountInput = document.getElementById('discount_code');
        if (discountInput) {
            discountInput.focus();
        }
    });
</script>
@endif
@endsection