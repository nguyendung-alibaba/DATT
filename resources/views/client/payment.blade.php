@extends('client.layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="checkout-header mb-4">
                <div class="d-flex align-items-center">
                    <div class="checkout-icon me-3">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 text-white fw-bold">Xác nhận thanh toán</h2>
                        <p class="text-white-75 mb-0">Hoàn tất đơn hàng của bạn</p>
                    </div>
                </div>
            </div>

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Hiển thị thông báo thành công --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="card order-summary-card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fas fa-receipt me-2"></i>
                                Thông tin đơn hàng của bạn
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if ($gioHang && $gioHang->chiTiet->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 modern-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 ps-4">Sản phẩm</th>
                                            <th class="border-0 text-center">Biến thể</th>
                                            <th class="border-0 text-center">Giá</th>
                                            <th class="border-0 text-center">Số lượng</th>
                                            <th class="border-0 text-end pe-4">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gioHang->chiTiet as $ct)
                                        <tr class="product-row">
                                            <td class="ps-4 py-3">
                                                <div class="product-info d-flex align-items-center">
                                                    @if($ct->sanPham->image)
                                                    <img src="{{ asset('storage/' . $ct->sanPham->image) }}"
                                                        alt="{{ $ct->sanPham->ten_san_pham }}"
                                                        class="product-thumb me-3">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $ct->sanPham->ten_san_pham ?? 'Không xác định' }}</h6>
                                                        <small class="text-muted">SKU: #{{ $ct->sanPham->product_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                @if($ct->variant)
                                                <div class="variant-info">
                                                    @if($ct->variant->color)
                                                    <span class="badge bg-secondary me-1">{{ $ct->variant->color->name }}</span>
                                                    @endif
                                                    @if($ct->variant->size)
                                                    <span class="badge bg-info">{{ $ct->variant->size->name }}</span>
                                                    @endif
                                                </div>
                                                @else
                                                <span class="text-muted">Mặc định</span>
                                                @endif
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
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">Tạm tính:</span>
                                <span class="fw-semibold text-dark">{{ number_format($tongTien) }}₫</span>
                            </div>
                            @if ($giamGia > 0)
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">Giảm giá:</span>
                                <span class="fw-semibold text-danger">-{{ number_format($giamGia) }}₫</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">Phí vận chuyển:</span>
                                <span class="fw-semibold text-success">Miễn phí</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="fs-5 fw-bold text-primary">Tổng cộng:</span>
                                <span class="fs-4 fw-bold text-danger">{{ number_format($thanhToan) }}₫</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card shipping-payment-card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="fas fa-truck me-2"></i>
                                Thông tin giao hàng & Thanh toán
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('checkout.process') }}" method="POST" id="paymentForm">
                                @csrf

                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user-circle me-2"></i>Thông tin người nhận
                                    </h6>

                                    <div class="mb-3">
                                        <label for="ten_nguoi_nhan" class="form-label fw-semibold">Tên người nhận <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="ten_nguoi_nhan" id="ten_nguoi_nhan" class="form-control" required value="{{ old('ten_nguoi_nhan', Auth::user()->name) }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', Auth::user()->email) }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="so_dien_thoai" class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" name="so_dien_thoai" id="so_dien_thoai" class="form-control" required value="{{ old('so_dien_thoai') }}" pattern="[0-9]{10,11}" placeholder="0123456789">
                                        </div>
                                    </div>

                                    <!-- Số nhà / Tên đường -->
                                    <div class="mb-3">
                                        <label for="so_nha" class="form-label fw-semibold">Số nhà, tên đường <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <input type="text" name="so_nha" id="so_nha" class="form-control" required
                                                placeholder="Số nhà, tên đường" value="{{ old('so_nha') }}">
                                        </div>
                                    </div>

                                    <!-- Tỉnh / Thành phố -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                        <select name="tinh_id" id="tinh" class="form-select" required>
                                            <option value="">-- Chọn tỉnh/thành --</option>
                                            @foreach($dsTinhThanh as $tinh)
                                            <option value="{{ $tinh->id }}">{{ $tinh->ten_tinh }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Phường / Xã -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Phường / Xã <span class="text-danger">*</span></label>
                                        <select name="phuong_xa_id" id="phuong_xa" class="form-select" required disabled>
                                            <option value="">-- Chọn phường/xã --</option>
                                        </select>
                                    </div>


                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-credit-card me-2"></i>Phương thức thanh toán
                                    </h6>

                                    <div class="form-check payment-option p-3 mb-3 rounded border" data-payment="cod">
                                        <input class="form-check-input mt-2" type="radio" name="phuong_thuc" id="cod" value="cod" checked>
                                        <label class="form-check-label d-flex align-items-center w-100" for="cod">
                                            <i class="fas fa-truck-loading me-3 fs-4 text-success"></i>
                                            <div class="flex-grow-1">
                                                <strong class="d-block">Thanh toán khi nhận hàng (COD)</strong>
                                                <small class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng. An toàn và tiện lợi.</small>
                                            </div>
                                            <div class="payment-fee text-end">
                                                <small class="text-success fw-bold">Miễn phí</small>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-check payment-option p-3 rounded border" data-payment="vnpay">
                                        <input class="form-check-input mt-2" type="radio" name="phuong_thuc" id="vnpay" value="vnpay">
                                        <label class="form-check-label d-flex align-items-center w-100" for="vnpay">
                                            <div class="vnpay-logo me-3">
                                                <img src="https://vnpay.vn/s1/statics.vnpay.vn/2023/9/06ncktiwd6dc1694418196384.png"
                                                    alt="VNPay" class="vnpay-img">
                                            </div>
                                            <div class="flex-grow-1">
                                                <strong class="d-block">Thanh toán VNPay</strong>
                                                <small class="text-muted">Thanh toán online qua VNPay. Hỗ trợ thẻ ATM, Visa, MasterCard, QR Code.</small>
                                            </div>
                                            <div class="payment-fee text-end">
                                                <small class="text-info fw-bold">An toàn</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="ghi_chu" class="form-label fw-semibold">Ghi chú đơn hàng</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                        <textarea name="ghi_chu" id="ghi_chu" rows="2" class="form-control" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn.">{{ old('ghi_chu') }}</textarea>
                                    </div>
                                </div>

                                <div class="order-summary-mobile d-lg-none mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <span>Tổng cộng:</span>
                                                <span class="fw-bold text-danger">{{ number_format($thanhToan) }}₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg confirm-order-btn">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <span class="btn-text">Xác nhận đặt hàng</span>
                                        <span class="btn-amount ms-2">({{ number_format($thanhToan) }}₫)</span>
                                    </button>
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg back-to-cart-btn">
                                        <i class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Thông tin bảo mật --}}
                    <div class="card mt-3 security-info">
                        <div class="card-body text-center py-3">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <i class="fas fa-shield-alt text-success me-2"></i>
                                <small class="fw-bold text-success">Thanh toán an toàn & bảo mật</small>
                            </div>
                            <div class="security-badges">
                                <i class="fab fa-cc-visa text-primary me-2"></i>
                                <i class="fab fa-cc-mastercard text-warning me-2"></i>
                                <i class="fas fa-university text-info me-2"></i>
                                <i class="fas fa-qrcode text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f4f7f6;
    }

    .checkout-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        padding: 2.5rem;
        border-radius: 20px;
        color: white;
        margin-bottom: 2.5rem;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .checkout-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .custom-alert {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .order-summary-card,
    .shipping-payment-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .order-summary-card:hover,
    .shipping-payment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        border-bottom: none;
        padding: 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
    }

    .order-summary-card .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #004085 100%);
    }

    .shipping-payment-card .card-header {
        background: linear-gradient(135deg, #198754 0%, #0f5132 100%);
    }

    .modern-table {
        font-size: 0.9rem;
    }

    .product-row {
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .product-row:hover {
        background-color: #e9f7ff;
        transform: scale(1.01);
    }

    .product-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }

    .variant-info .badge {
        font-size: 0.7rem;
    }

    .price-text {
        color: #495057;
        font-weight: 500;
    }

    .quantity-badge {
        background: #6c757d;
        color: white;
        padding: 5px 14px;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .total-price {
        color: #dc3545;
        font-size: 1.15rem;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
        padding: 1.5rem;
    }

    .form-label {
        font-size: 0.95rem;
        color: #343a40;
    }

    .input-group-text {
        background-color: #e9ecef;
        border-right: none;
        color: #495057;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    .form-control {
        border-left: none;
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .payment-option {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #dee2e6 !important;
        position: relative;
    }

    .payment-option:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd !important;
    }

    .payment-option.selected {
        border-color: #0d6efd !important;
        background-color: #f0f7ff;
    }

    .vnpay-logo {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .vnpay-img {
        width: 40px;
        height: auto;
    }

    .payment-fee {
        min-width: 60px;
    }

    .confirm-order-btn {
        background: linear-gradient(135deg, #28a745 0%, #17a2b8 100%);
        border: none;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        position: relative;
        overflow: hidden;
    }

    .confirm-order-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #17a2b8 0%, #28a745 100%);
    }

    .confirm-order-btn:active {
        transform: translateY(-1px);
    }

    .back-to-cart-btn {
        border: 2px solid #6c757d;
        color: #6c757d;
        font-weight: 600;
        border-radius: 12px;
        padding: 1rem 2rem;
        transition: all 0.3s ease;
    }

    .back-to-cart-btn:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.2);
    }

    .security-info {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .security-badges i {
        font-size: 1.2rem;
    }

    .order-summary-mobile {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 991.98px) {
        .checkout-header {
            text-align: center;
            padding: 1.8rem;
        }

        .checkout-icon {
            margin: 0 auto 1rem;
        }

        .product-thumb {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 767.98px) {
        .container-fluid {
            padding: 0 1rem;
        }

        .modern-table {
            font-size: 0.8rem;
        }

        .modern-table th,
        .modern-table td {
            padding: 0.6rem !important;
        }

        .quantity-badge {
            padding: 3px 10px;
            font-size: 0.7rem;
        }

        .card-header {
            padding: 1rem;
            font-size: 1rem;
        }

        .confirm-order-btn,
        .back-to-cart-btn {
            font-size: 0.95rem;
            padding: 0.8rem 1.5rem;
        }

        .payment-option {
            padding: 1rem !important;
        }

        .vnpay-logo {
            width: 40px;
            height: 40px;
        }

        .vnpay-img {
            width: 30px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentOptions = document.querySelectorAll('.payment-option');
        const confirmBtn = document.querySelector('.confirm-order-btn .btn-text');

        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                const paymentMethod = this.dataset.payment;
                if (paymentMethod === 'vnpay') {
                    confirmBtn.textContent = 'Thanh toán VNPay';
                } else {
                    confirmBtn.textContent = 'Xác nhận đặt hàng';
                }
            });
        });

        const checkedOption = document.querySelector('input[name="phuong_thuc"]:checked');
        if (checkedOption) {
            const parentOption = checkedOption.closest('.payment-option');
            parentOption.classList.add('selected');
        }

        const form = document.getElementById('paymentForm');
        form.addEventListener('submit', function(e) {
            const phone = document.getElementById('so_dien_thoai').value;
            const phoneRegex = /^[0-9]{10,11}$/;
            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                alert('Số điện thoại không hợp lệ. Vui lòng nhập 10-11 chữ số.');
                return false;
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const tinhSelect = document.getElementById('tinh');
        const xaSelect = document.getElementById('phuong_xa');

        tinhSelect.addEventListener('change', function() {
            const tinhId = this.value;
            xaSelect.innerHTML = '<option value="">-- Đang tải phường/xã... --</option>';
            xaSelect.disabled = true;

            if (!tinhId) return;

            fetch(`/api/phuong-xa?tinh_id=${tinhId}`)
                .then(res => res.json())
                .then(data => {
                    xaSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
                    data.forEach(xa => {
                        const opt = document.createElement('option');
                        opt.value = xa.id;
                        opt.textContent = xa.ten_phuong_xa;
                        xaSelect.appendChild(opt);
                    });
                    xaSelect.disabled = false;
                })
                .catch(() => {
                    xaSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
                });
        });
    });
</script>
@endsection