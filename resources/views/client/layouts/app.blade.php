<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fona - SmartPhone Pro - Điện thoại iPhone & Samsung mới nhất')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Bootstrap (tiện dùng các class như btn, container) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animate.css cho hiệu ứng chữ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        .hero-section {
            height: 80vh;
            overflow: hidden;
        }

        .swiper-slide {
            position: relative;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background-size: cover;
            background-position: center;
        }

        .slide-overlay {
            position: absolute;
            inset: 0;
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 600px;
            animation-duration: 1.5s;
        }

        .swiper-slide-active {
            transform: scale(1.03);
            transition: transform 2s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 100%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
            z-index: 0;
        }

        .hero-section .container {
            position: relative;
            z-index: 1;
        }

        .hero-phone {
            animation-duration: 1.5s;
            animation-delay: 0.3s;
            transition: transform 0.3s ease;
            max-width: 100%;
        }

        .hero-phone:hover {
            transform: scale(1.05);
        }


        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
            }
        }

        .testimonial-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .stats-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 80px 0;
            border-top-right-radius: 50px;
            border-bottom-left-radius: 50px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .newsletter-section {
            background: #ffffff;
            padding: 80px 0;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 50px;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 6px 15px rgba(118, 75, 162, 0.4);
        }

        .auth-tab {
            border: none;
            background: transparent;
            color: #6c757d;
            padding: 15px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .auth-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .category-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .hero-phone {
            max-width: 300px;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
            animation: floatPhone 6s ease-in-out infinite;
        }

        @keyframes floatPhone {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 2rem;
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.2);
        }

        /* Product card specific styles */
        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .product-card .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 250px;
            object-fit: contain;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .product-card .card-body {
            padding: 25px;
        }

        .product-card .card-title {
            font-weight: bold;
            color: #333;
            min-height: 50px;
        }

        .product-card .card-text {
            min-height: 45px;
        }

        .product-card .price-original {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9em;
        }

        .product-card .badge-custom {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: normal;
            z-index: 2;
        }

        .rating-stars .bi-star-fill,
        .rating-stars .bi-star-half {
            color: #ffc107;
        }

        .rating-stars .bi-star {
            color: #e0e0e0;
        }

        .navbar-brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #333;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #764ba2;
        }

        .footer {
            background: #343a40;
            color: white;
            padding: 50px 0;
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #667eea;
        }

        .hero-section {
            height: 100vh;
            overflow: hidden;
        }

        .swiper-slide {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background-size: cover;
            background-position: center;
        }

        .slide-overlay {
            position: absolute;
            inset: 0;
            backdrop-filter: blur(4px);
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 600px;
            animation-duration: 1.5s;
        }

        /* Zoom ảnh khi chuyển slide */
        .swiper-slide-active {
            transform: scale(1.05);
            transition: transform 2s ease;
        }
    </style>
    @yield('styles') {{-- Để thêm CSS tùy chỉnh cho từng trang cụ thể nếu cần --}}
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('products.index') }}">
                <div class="navbar-brand-icon me-2">Fona</div>
                <span class="fw-bold fs-4 text-dark">SmartPhone Pro</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('products.index') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Ưu điểm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Liên hệ</a>
                    </li>
                </ul>
                <li><a href="{{ route('client.donhang.index') }}">Đơn hàng của tôi</a></li>
                <div class="d-flex ms-lg-3">
                    <button class="btn btn-outline-secondary me-2" type="button" data-bs-toggle="modal"
                        data-bs-target="#authModal">
                        <i class="bi bi-person-circle me-1"></i>Tài khoản
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary position-relative">
                        <i class="bi bi-cart3"></i>
                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                            {{ $cartCount ?? 0 }} {{-- Sử dụng 0 nếu $cartCount không được định nghĩa --}}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content') {{-- Đây là nơi nội dung chính của từng trang sẽ được đưa vào --}}
    </main>

    <footer id="contact" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">SmartPhone Pro</h5>
                    <p class="text-muted">Chuyên cung cấp các dòng điện thoại iPhone và Samsung mới nhất, phụ kiện chính hãng, với dịch vụ tận tâm và giá cả cạnh tranh.</p>
                    <div class="d-flex social-icons mt-3">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-4"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube fs-4"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="text-white mb-3">Danh mục</h5>
                    <ul class="list-unstyled">
                        <li><a href="#products">iPhone</a></li>
                        <li><a href="#products">Samsung</a></li>
                        <li><a href="#products">Phụ kiện</a></li>
                        <li><a href="#products">Sản phẩm khuyến mãi</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-white mb-3">Hỗ trợ khách hàng</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Trung tâm trợ giúp</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản dịch vụ</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-white mb-3">Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li class="text-muted"><i class="bi bi-geo-alt-fill me-2"></i>123 Đường ABC, Quận XYZ, TP.HCM</li>
                        <li class="text-muted"><i class="bi bi-phone-fill me-2"></i><a href="tel:+84987654321">0987 654 321</a></li>
                        <li class="text-muted"><i class="bi bi-envelope-fill me-2"></i><a href="mailto:info@smartphonepro.com">info@smartphonepro.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center pt-4 border-top border-secondary">
                <p class="mb-0 text-muted">&copy; 2025 SmartPhone Pro. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pt-0">
                    <ul class="nav nav-pills nav-justified mb-4" id="authTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link auth-tab active" id="login-tab" data-bs-toggle="pill"
                                data-bs-target="#login" type="button" role="tab" aria-controls="login"
                                aria-selected="true">Đăng nhập</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link auth-tab" id="register-tab" data-bs-toggle="pill"
                                data-bs-target="#register" type="button" role="tab" aria-controls="register"
                                aria-selected="false">Đăng ký</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="authTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel"
                            aria-labelledby="login-tab">
                            <h5 class="text-center mb-4 fw-bold">Đăng nhập vào tài khoản của bạn</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="loginEmail" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="loginPassword"
                                        placeholder="Mật khẩu của bạn">
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">
                                            Nhớ mật khẩu
                                        </label>
                                    </div>
                                    <a href="#" class="text-decoration-none text-primary">Quên mật khẩu?</a>
                                </div>
                                <button type="submit" class="btn btn-gradient w-100 mb-3">Đăng nhập</button>
                                <div class="text-center text-muted mb-3">Hoặc đăng nhập bằng</div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-danger" type="button"><i
                                            class="bi bi-google me-2"></i>Google</button>
                                    <button class="btn btn-outline-primary" type="button"><i
                                            class="bi bi-facebook me-2"></i>Facebook</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <h5 class="text-center mb-4 fw-bold">Tạo tài khoản mới</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="registerName" placeholder="Nguyễn Văn A">
                                </div>
                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="registerEmail" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="registerPassword"
                                        placeholder="Tối thiểu 6 ký tự">
                                </div>
                                <div class="mb-4">
                                    <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        placeholder="Nhập lại mật khẩu">
                                </div>
                                <button type="submit" class="btn btn-gradient w-100 mb-3">Đăng ký</button>
                                <div class="text-center text-muted mb-3">Hoặc đăng ký bằng</div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-danger" type="button"><i
                                            class="bi bi-google me-2"></i>Google</button>
                                    <button class="btn btn-outline-primary" type="button"><i
                                            class="bi bi-facebook me-2"></i>Facebook</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts') {{-- Để thêm JS tùy chỉnh cho từng trang cụ thể nếu cần --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
</body>

</html>