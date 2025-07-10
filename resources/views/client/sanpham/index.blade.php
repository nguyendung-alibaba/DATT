@extends('client.layouts.app') {{-- Kế thừa layout master --}}

@section('title', 'Trang chủ - SmartPhone Pro') {{-- Đặt tiêu đề riêng cho trang này --}}
@section('styles')
@section('content') {{-- Bắt đầu phần nội dung chính --}}
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4 position-relative">
                        Khám phá thế giới<br>
                        <span class="text-warning">Smartphone</span> mới nhất
                    </h1>
                    <p class="lead mb-4">
                        Tìm hiểu những chiếc điện thoại thông minh tốt nhất với công nghệ tiên tiến nhất,
                        giá cả hợp lý và dịch vụ hậu mãi tuyệt vời.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#products" class="btn btn-gradient btn-lg px-4">
                            <i class="bi bi-cart-plus me-2"></i>Mua ngay
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-play-circle me-2"></i>Tìm hiểu thêm
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='600' viewBox='0 0 300 600'%3E%3Crect width='300' height='600' rx='40' fill='%23f8f9fa'/%3E%3Crect x='20' y='60' width='260' height='480' rx='20' fill='%23000'/%3E%3Ctext x='150' y='30' text-anchor='middle' fill='%23333' font-size='16' font-family='Arial'%3EiPhone 15 Pro%3C/text%3E%3C/svg%3E"
                        alt="Latest Smartphone" class="hero-phone img-fluid">
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Danh mục sản phẩm</h2>
                <p class="text-muted">Chọn thương hiệu yêu thích của bạn</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="category-card">
                        <div>
                            <div class="feature-icon mb-3">
                                <i class="bi bi-apple"></i>
                            </div>
                            <h4>iPhone</h4>
                            <p class="text-muted mb-4">Dòng sản phẩm iPhone mới nhất với công nghệ Apple tiên tiến
                            </p>
                        </div>
                        <a href="#" class="btn btn-gradient mt-3">Xem ngay</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <div>
                            <div class="feature-icon mb-3">
                                <i class="bi bi-phone"></i>
                            </div>
                            <h4>Samsung Galaxy</h4>
                            <p class="text-muted mb-4">Samsung Galaxy với màn hình tuyệt đẹp và hiệu năng mạnh mẽ
                            </p>
                        </div>
                        <a href="#" class="btn btn-gradient mt-3">Xem ngay</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <div>
                            <div class="feature-icon mb-3">
                                <i class="bi bi-headphones"></i>
                            </div>
                            <h4>Phụ kiện</h4>
                            <p class="text-muted mb-4">Tai nghe, ốp lưng, sạc và các phụ kiện chính hãng</p>
                        </div>
                        <a href="#" class="btn btn-gradient mt-3">Xem ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section id="products" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Sản phẩm nổi bật</h2>
                <p class="text-muted">Những chiếc điện thoại được yêu thích nhất</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <span class="badge bg-danger badge-custom">-15%</span>
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300' viewBox='0 0 300 300'%3E%3Crect width='300' height='300' fill='%23f8f9fa'/%3E%3Crect x='75' y='50' width='150' height='200' rx='20' fill='%23000'/%3E%3Ctext x='150' y='280' text-anchor='middle' fill='%23333' font-size='14'%3EiPhone 15 Pro%3C/text%3E%3C/svg%3E"
                                class="card-img-top" alt="iPhone 15 Pro">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">iPhone 15 Pro</h5>
                            <p class="card-text text-muted">Chip A17 Pro, Camera 48MP, Titanium</p>
                            <div class="rating-stars mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="text-muted ms-1">(128)</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="price-original me-2">35.990.000₫</span>
                                <span class="fw-bold text-danger fs-5">30.590.000₫</span>
                            </div>
                            <button class="btn btn-gradient w-100 mt-auto">
                                <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <span class="badge bg-success badge-custom">Mới</span>
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300' viewBox='0 0 300 300'%3E%3Crect width='300' height='300' fill='%23f8f9fa'/%3E%3Crect x='75' y='50' width='150' height='200' rx='20' fill='%23333'/%3E%3Ctext x='150' y='280' text-anchor='middle' fill='%23333' font-size='14'%3ESamsung S24 Ultra%3C/text%3E%3C/svg%3E"
                                class="card-img-top" alt="Samsung Galaxy S24 Ultra">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Samsung Galaxy S24 Ultra</h5>
                            <p class="card-text text-muted">Snapdragon 8 Gen 3, S Pen, AI</p>
                            <div class="rating-stars mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted ms-1">(94)</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-danger fs-5">32.990.000₫</span>
                            </div>
                            <button class="btn btn-gradient w-100 mt-auto">
                                <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300' viewBox='0 0 300 300'%3E%3Crect width='300' height='300' fill='%23f8f9fa'/%3E%3Crect x='75' y='50' width='150' height='200' rx='20' fill='%23666'/%3E%3Ctext x='150' y='280' text-anchor='middle' fill='%23333' font-size='14'%3EiPhone 14%3C/text%3E%3C/svg%3E"
                                class="card-img-top" alt="iPhone 14">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">iPhone 14</h5>
                            <p class="card-text text-muted">Chip A15 Bionic, Dual Camera</p>
                            <div class="rating-stars mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <span class="text-muted ms-1">(156)</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-danger fs-5">22.990.000₫</span>
                            </div>
                            <button class="btn btn-gradient w-100 mt-auto">
                                <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <span class="badge bg-warning badge-custom">Hot</span>
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300' viewBox='0 0 300 300'%3E%3Crect width='300' height='300' fill='%23f8f9fa'/%3E%3Crect x='75' y='50' width='150' height='200' rx='20' fill='%23444'/%3E%3Ctext x='150' y='280' text-anchor='middle' fill='%23333' font-size='14'%3ESamsung S23%3C/text%3E%3C/svg%3E"
                                class="card-img-top" alt="Samsung Galaxy S23">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Samsung Galaxy S23</h5>
                            <p class="card-text text-muted">Snapdragon 8 Gen 2, 50MP</p>
                            <div class="rating-stars mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="text-muted ms-1">(203)</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-danger fs-5">19.990.000₫</span>
                            </div>
                            <button class="btn btn-gradient w-100 mt-auto">
                                <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Tại sao chọn SmartPhone Pro?</h2>
                <p class="text-muted">Những lý do khiến khách hàng tin tưởng chúng tôi</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>Bảo hành chính hãng</h4>
                    <p class="text-muted">Tất cả sản phẩm đều có bảo hành chính hãng từ 12-24 tháng</p>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>Giao hàng miễn phí</h4>
                    <p class="text-muted">Miễn phí giao hàng toàn quốc cho đơn hàng từ 5 triệu đồng</p>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h4>Đổi trả dễ dàng</h4>
                    <p class="text-muted">Chính sách đổi trả trong vòng 7 ngày nếu không hài lòng</p>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>Hỗ trợ 24/7</h4>
                    <p class="text-muted">Đội ngũ tư vấn chuyên nghiệp hỗ trợ khách hàng 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-number">50K+</div>
                    <p class="mb-0">Khách hàng hài lòng</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-number">1000+</div>
                    <p class="mb-0">Sản phẩm chính hãng</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-number">5</div>
                    <p class="mb-0">Năm kinh nghiệm</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-number">99%</div>
                    <p class="mb-0">Tỷ lệ hài lòng</p>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Khách hàng nói gì về chúng tôi</h2>
                <p class="text-muted">Những phản hồi tích cực từ khách hàng</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">AM</div>
                        <h5>Anh Minh</h5>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted">"Dịch vụ tuyệt vời, sản phẩm chất lượng và giá cả hợp lý. Tôi sẽ
                            tiếp tục ủng hộ SmartPhone Pro."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">LH</div>
                        <h5>Chị Linh</h5>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted">"Nhân viên tư vấn nhiệt tình, giao hàng nhanh chóng. iPhone mình mua
                            hoạt động rất tốt."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">DT</div>
                        <h5>Anh Tuấn</h5>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="text-muted">"Shop uy tín, sản phẩm chính hãng 100%. Chính sách bảo hành và hậu
                            mãi rất tốt."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section class="newsletter-section container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Đăng ký nhận tin tức mới nhất</h2>
                <p class="text-muted mb-4">Nhận thông tin về sản phẩm mới, khuyến mãi đặc biệt và các tin tức công
                    nghệ hàng tuần.</p>
            </div>
            <div class="col-lg-6">
                <div class="input-group input-group-lg">
                    <input type="email" class="form-control" placeholder="Nhập email của bạn...">
                    <button class="btn btn-gradient px-4" type="button">
                        <i class="bi bi-envelope me-2"></i>Đăng ký
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection