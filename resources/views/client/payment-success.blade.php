@extends('client.layouts.app')

@section('title', 'Thanh toán thành công')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Header -->
            <div class="success-header text-center mb-5">
                <div class="success-icon-wrapper">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="success-animation">
                        <div class="checkmark">
                            <svg class="checkmark__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark__check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <h1 class="success-title">Thanh toán thành công!</h1>
                <p class="success-subtitle">Cảm ơn bạn đã tin tưởng và mua sắm tại Fona Shop</p>
                @if(isset($donHang) && $donHang)
                    <div class="order-code">
                        <span class="order-label">Mã đơn hàng:</span>
                        <span class="order-number">{{ $donHang->ma_don_hang }}</span>
                    </div>
                @endif
            </div>

            @if(isset($donHang) && $donHang)
                <!--Thông tin đặt hàng -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="card info-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Thông tin người nhận
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <span class="info-label">Họ tên:</span>
                                    <span class="info-value">{{ $donHang->ten_nguoi_nhan }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">{{ $donHang->email }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Số điện thoại:</span>
                                    <span class="info-value">{{ $donHang->so_dien_thoai }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Địa chỉ:</span>
                                    <span class="info-value">{{ $donHang->dia_chi }}</span>
                                </div>
                                @if($donHang->ghi_chu)
                                    <div class="info-item">
                                        <span class="info-label">Ghi chú:</span>
                                        <span class="info-value">{{ $donHang->ghi_chu }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card info-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Thông tin đơn hàng
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <span class="info-label">Ngày đặt:</span>
                                    <span class="info-value">{{ $donHang->ngay_dat->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Trạng thái:</span>
                                    <span class="badge bg-success">{{ $donHang->trang_thai_text }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Phương thức thanh toán:</span>
                                    <span class="info-value">{{ $donHang->phuong_thuc_thanh_toan_text }}</span>
                                </div>
                                @if($donHang->ma_giam_gia)
                                    <div class="info-item">
                                        <span class="info-label">Mã giảm giá:</span>
                                        <span class="badge bg-info">{{ $donHang->ma_giam_gia }}</span>
                                    </div>
                                @endif
                                <div class="info-item">
                                    <span class="info-label">Thời gian giao hàng dự kiến:</span>
                                    <span class="info-value text-primary">2-3 ngày làm việc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết đặt hàng -->
                <div class="card order-details-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>Chi tiết đơn hàng
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                    @foreach($donHang->chiTiet as $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($item->sanPham && $item->sanPham->image)
                                                        <img src="{{ asset('storage/' . $item->sanPham->image) }}"
                                                             alt="{{ $item->ten_san_pham }}"
                                                             class="product-thumb me-3">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $item->ten_san_pham }}</h6>
                                                        <small class="text-muted">SKU: #{{ $item->product_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                @if($item->variant)
                                                    <div class="variant-info">
                                                        @if($item->variant->color)
                                                            <span class="badge bg-secondary me-1">{{ $item->variant->color->name }}</span>
                                                        @endif
                                                        @if($item->variant->size)
                                                            <span class="badge bg-info">{{ $item->variant->size->name }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">Mặc định</span>
                                                @endif
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="fw-semibold">{{ number_format($item->don_gia) }}₫</span>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="quantity-badge">{{ $item->so_luong }}</span>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <span class="fw-bold text-primary">{{ number_format($item->thanh_tien) }}₫</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <div class="order-summary">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tạm tính:</span>
                                        <span>{{ number_format($donHang->tong_tien) }}₫</span>
                                    </div>
                                    @if($donHang->giam_gia > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Giảm giá:</span>
                                            <span class="text-danger">-{{ number_format($donHang->giam_gia) }}₫</span>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Phí vận chuyển:</span>
                                        <span class="text-success">Miễn phí</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold fs-5">Tổng cộng:</span>
                                        <span class="fw-bold fs-4 text-danger">{{ number_format($donHang->thanh_toan) }}₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Thông báo chung khi không có thông tin đơn hàng -->
                <div class="card info-card mb-4">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-gift fa-3x text-primary mb-3"></i>
                            <h4>Đơn hàng của bạn đã được xử lý thành công!</h4>
                            <p class="text-muted">Chúng tôi sẽ gửi email xác nhận đến địa chỉ email của bạn trong vài phút tới.</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card next-steps-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Bước tiếp theo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="step-item">
                                <div class="step-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h6>Xác nhận qua email</h6>
                                <p class="text-muted small">Chúng tôi đã gửi email xác nhận đơn hàng đến địa chỉ của bạn</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="step-item">
                                <div class="step-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h6>Chuẩn bị hàng</h6>
                                <p class="text-muted small">Đơn hàng sẽ được chuẩn bị và đóng gói trong 1-2 giờ</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="step-item">
                                <div class="step-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <h6>Giao hàng</h6>
                                <p class="text-muted small">Đơn hàng sẽ được giao trong 2-3 ngày làm việc</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mb-5">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-home me-2"></i>Về trang chủ
                </a>
                <a href="/client/products" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i>Tiếp tục mua sắm
                </a>
            </div>

            <!-- Contact Support -->
            <div class="card support-card">
                <div class="card-body text-center">
                    <h5 class="mb-3">
                        <i class="fas fa-headset me-2"></i>Cần hỗ trợ?
                    </h5>
                    <p class="text-muted mb-3">Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi</p>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-phone text-success me-2"></i>
                            <span>Hotline: 1900 1234</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <span>Email: support@fonashop.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook text-info me-2"></i>
                            <span>Facebook: Fona Shop Official</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .success-header {
        background: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .success-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: rotate(45deg);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .success-icon-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
    }

    .success-icon {
        font-size: 4rem;
        color: #28a745;
        animation: bounceIn 1s ease-out;
    }

    @keyframes bounceIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .success-animation {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
    }

    .checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #28a745;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #28a745;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #28a745;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }

    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }

    @keyframes fill {
        100% { box-shadow: inset 0px 0px 0px 30px #28a745; }
    }

    .success-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1rem;
        animation: fadeInUp 1s ease-out 0.5s both;
    }

    .success-subtitle {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 2rem;
        animation: fadeInUp 1s ease-out 0.7s both;
    }

    .order-code {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        display: inline-block;
        animation: fadeInUp 1s ease-out 0.9s both;
    }

    .order-label {
        font-weight: 500;
        margin-right: 0.5rem;
    }

    .order-number {
        font-weight: 700;
        font-size: 1.1rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .info-card, .order-details-card, .next-steps-card, .support-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-card:hover, .order-details-card:hover, .next-steps-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-bottom: none;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
    }

    .info-value {
        font-weight: 500;
        color: #212529;
        text-align: right;
        flex: 1;
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

    .quantity-badge {
        background: #6c757d;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .order-summary {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
    }

    .step-item {
        padding: 1rem;
    }

    .step-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
        transition: transform 0.3s ease;
    }

    .step-item:hover .step-icon {
        transform: scale(1.1);
    }

    .contact-info {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .btn-lg {
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    @media (max-width: 768px) {
        .success-title {
            font-size: 2rem;
        }

        .success-subtitle {
            font-size: 1rem;
        }

        .contact-info {
            flex-direction: column;
            gap: 1rem;
        }

        .contact-item {
            justify-content: center;
        }

        .btn-lg {
            width: 100%;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection