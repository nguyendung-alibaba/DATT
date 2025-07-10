@extends('client.layouts.app')

@section('title', 'SmartPhone Pro - Latest iPhones & Samsung Phones')

@section('styles')
{{-- Custom CSS for this page --}}
<style>
    /* Hero Section Specific Styles */

    .hero-section {
        position: relative;
        overflow: hidden;
        height: 600px;
        /* Adjust height as needed */
        background-color: #f8f9fa;
        /* Fallback background color */
    }

    .swiper-slide {
        height: 100%;
        background-size: cover !important;
        background-position: center !important;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        /* Default text color for hero content */
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        /* Text shadow for readability */
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        /* Dark overlay for better text visibility */
        z-index: 1;
    }

    .swiper-slide .container {
        position: relative;
        z-index: 2;
        /* Ensure content is above overlay */
    }

    .hero-phone {
        max-height: 400px;
        width: auto;
        object-fit: contain;
    }

    /* Swiper Navigation and Pagination */
    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        --swiper-navigation-size: 30px;
    }

    .swiper-pagination-bullet-active {
        background-color: #fff;
    }

    /* Product Card Enhancements */
    .product-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .product-card.transform-on-hover:hover {
        transform: translateY(-5px);
        /* Lift effect on hover */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        /* Stronger shadow on hover */
    }

    .product-card .img-fluid {
        transition: transform 0.3s ease-in-out;
    }

    .product-card.transform-on-hover:hover .img-fluid {
        transform: scale(1.05);
        /* Slight zoom effect on image hover */
    }

    .product-card .badge-custom {
        border-radius: 0.3rem;
        font-weight: 600;
        padding: 0.3em 0.6em;
    }

    .rating-stars .bi-star-fill,
    .rating-stars .bi-star-half {
        color: #ffc107;
        /* Bootstrap yellow for stars */
    }

    .product-features li {
        margin-bottom: 0.25rem;
        /* Space between list items */
    }

    /* Custom badge colors */
    .bg-pink {
        background-color: #ffc0cb !important;
    }

    .recommendation-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        margin-top: 2rem;
        padding: 2rem;
    }

    .recommendation-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .recommendation-title {
        position: relative;
        z-index: 2;
        color: white;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .recommendation-title::before {
        content: "🧠";
        font-size: 2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .recommendation-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        transform: translateY(0);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .recommendation-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .recommendation-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }

    .recommendation-card:hover::before {
        left: 100%;
    }

    .recommendation-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .recommendation-card:hover .card-img-top {
        transform: scale(1.1);
    }

    .recommendation-card .card-body {
        padding: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .recommendation-card .card-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.8rem;
        line-height: 1.4;
    }

    .recommendation-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 0.5rem;
    }

    .recommendation-original-price {
        font-size: 0.9rem;
        color: #7f8c8d;
        text-decoration: line-through;
        margin-bottom: 1rem;
    }

    .recommendation-btn {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .recommendation-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.3s ease, height 0.3s ease;
    }

    .recommendation-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .recommendation-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #e74c3c;
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    .recommendation-slider-container {
        position: relative;
        overflow: hidden;
        margin-top: 1.5rem;
    }

    .recommendation-grid {
        display: flex;
        gap: 1.5rem;
        transition: transform 0.3s ease;
        will-change: transform;
    }

    .recommendation-grid .recommendation-card {
        flex: 0 0 280px;
        min-height: 400px;
    }

    /* Navigation Buttons */
    .recommendation-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
    }

    .recommendation-nav:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .recommendation-nav.prev {
        left: -25px;
    }

    .recommendation-nav.next {
        right: -25px;
    }

    .recommendation-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: translateY(-50%) scale(0.9);
    }

    .recommendation-nav i {
        font-size: 1.2rem;
        color: #667eea;
        transition: color 0.3s ease;
    }

    .recommendation-nav:hover i {
        color: #764ba2;
    }

    /* Dots indicator */
    .recommendation-dots {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .recommendation-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .recommendation-dot.active {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.2);
    }

    .recommendation-dot:hover {
        background: rgba(255, 255, 255, 0.8);
    }

    @media (max-width: 768px) {
        .recommendation-section {
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .recommendation-grid .recommendation-card {
            flex: 0 0 250px;
        }
        
        .recommendation-nav {
            width: 45px;
            height: 45px;
        }
        
        .recommendation-nav.prev {
            left: -22px;
        }
        
        .recommendation-nav.next {
            right: -22px;
        }
    }

    @media (max-width: 480px) {
        .recommendation-grid .recommendation-card {
            flex: 0 0 220px;
        }
        
        .recommendation-nav {
            width: 40px;
            height: 40px;
        }
        
        .recommendation-nav.prev {
            left: -20px;
        }
        
        .recommendation-nav.next {
            right: -20px;
        }
    }
</style>
@endsection

@section('content')

<section class="hero-section">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            {{-- Slide 1: iPhone 16 Pro Max --}}
            <div class="swiper-slide" style="background-image: url('https://cdn2.cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iPhone-16-Pro-Max-12.jpg');">
                <div class="slide-overlay"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="content animate__animated animate__fadeInLeft">
                                <span class="badge bg-warning text-dark mb-3 px-3 py-2 fs-6 shadow-sm">🔥 Đang Gây Sốt</span>
                                <h1 class="display-5 fw-bold mb-3">iPhone 16 Pro Max - Đỉnh Cao Công Nghệ</h1>
                                <p class="lead mb-4">Trải nghiệm hiệu năng vượt trội, camera đỉnh cao và thiết kế sang trọng. Mua ngay kẻo lỡ!</p>
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <a href="#" class="btn btn-light btn-lg px-4 shadow">Mua Ngay</a>
                                    <a href="#" class="btn btn-outline-light btn-lg px-4">Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center mt-4 mt-lg-0">
                            <img src="{{ asset('images/iphone/iphone-16-pro-max-sa-mac-thumb-1-600x600.jpg') }}" alt="iPhone 16 Pro Max"
                                class="img-fluid hero-phone shadow-lg rounded-4 animate__animated animate__zoomIn">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2: iPhone 16 Hồng --}}
            <div class="swiper-slide" style="background-image: url('https://cdn2.cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iPhone-16-Pro-Max-12.jpg');">
                <div class="slide-overlay"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="content animate__animated animate__fadeInLeft">
                                <span class="badge bg-pink text-dark mb-3 px-3 py-2 fs-6 shadow-sm">🎀 Phiên Bản Mới</span>
                                <h1 class="display-5 fw-bold mb-3">iPhone 16 Hồng Ngọt Ngào</h1>
                                <p class="lead mb-4">Dành riêng cho phái đẹp – tinh tế, hiện đại và đầy quyến rũ.</p>
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <a href="#" class="btn btn-light btn-lg px-4 shadow">Khám Phá</a>
                                    <a href="#" class="btn btn-outline-light btn-lg px-4">So Sánh</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center mt-4 mt-lg-0">
                            <img src="{{ asset('images/iphone/iphone-16-pink-600x600.png') }}" alt="iPhone 16 Pink"
                                class="img-fluid hero-phone shadow-lg rounded-4 animate__animated animate__zoomIn">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3: Galaxy Z Fold6 --}}
            <div class="swiper-slide" style="background-image: url('https://cdn2.cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iPhone-16-Pro-Max-12.jpg');">
                <div class="slide-overlay"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="content animate__animated animate__fadeInLeft">
                                <span class="badge bg-success text-white mb-3 px-3 py-2 fs-6 shadow-sm">✨ Gập Mở Tương Lai</span>
                                <h1 class="display-5 fw-bold mb-3">Galaxy Z Fold6 - Đột Phá Thiết Kế</h1>
                                <p class="lead mb-4">Màn hình gập siêu mượt, đa nhiệm mạnh mẽ – hoàn hảo cho công việc & giải trí.</p>
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <a href="#" class="btn btn-light btn-lg px-4 shadow">Xem Ngay</a>
                                    <a href="#" class="btn btn-outline-light btn-lg px-4">Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center mt-4 mt-lg-0">
                            <img src="{{ asset('images/samsung/samsung-galaxy-z-fold6-(80).jpg') }}" alt="Galaxy Z Fold6"
                                class="img-fluid hero-phone shadow-lg rounded-4 animate__animated animate__zoomIn">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 4: Xiaomi 15 Ultra --}}
            <div class="swiper-slide" style="background-image: url('https://cdn2.cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iPhone-16-Pro-Max-12.jpg');">
                <div class="slide-overlay"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="content animate__animated animate__fadeInLeft">
                                <span class="badge bg-primary text-white mb-3 px-3 py-2 fs-6 shadow-sm">📸 Camera Siêu Chất</span>
                                <h1 class="display-5 fw-bold mb-3">Xiaomi 15 Ultra - Vượt Mọi Giới Hạn</h1>
                                <p class="lead mb-4">Ống kính Leica, pin trâu, cấu hình siêu mạnh. Giá cực hời hôm nay!</p>
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <a href="#" class="btn btn-light btn-lg px-4 shadow">Mua Ngay</a>
                                    <a href="#" class="btn btn-outline-light btn-lg px-4">Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center mt-4 mt-lg-0">
                            <img src="{{ asset('images/xiaomi/xiaomi-15-ultra-trang-(22).jpg') }}" alt="Xiaomi 15 Ultra"
                                class="img-fluid hero-phone shadow-lg rounded-4 animate__animated animate__zoomIn">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 5: Xiaomi 14T Pro 5G --}}
            <div class="swiper-slide" style="background-image: url('https://cdn2.cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iPhone-16-Pro-Max-12.jpg');">
                <div class="slide-overlay"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="content animate__animated animate__fadeInLeft">
                                <span class="badge bg-info text-dark mb-3 px-3 py-2 fs-6 shadow-sm">⚡ Siêu Giá Trị</span>
                                <h1 class="display-5 fw-bold mb-3">Xiaomi 14T Pro 5G - Mạnh Mẽ Vượt Trội</h1>
                                <p class="lead mb-4">Chip Dimensity, 144Hz – hiệu năng xứng tầm flagship chỉ từ 9.9 triệu!</p>
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <a href="#" class="btn btn-light btn-lg px-4 shadow">Khám Phá</a>
                                    <a href="#" class="btn btn-outline-light btn-lg px-4">So Sánh</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center mt-4 mt-lg-0">
                            <img src="{{ asset('images/xiaomi/xiaomi-14t-pro-5g-12gb-256gb-(76).jpg') }}" alt="Xiaomi 14T Pro"
                                class="img-fluid hero-phone shadow-lg rounded-4 animate__animated animate__zoomIn">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Swiper navigation and pagination --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

---

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bolder mb-3 text-dark">Khám Phá Sức Mạnh Trong Tầm Tay</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Đắm mình vào thế giới của công nghệ di động đỉnh cao! Chúng tôi tự hào giới thiệu bộ sưu tập **smartphone nổi bật** được tuyển chọn kỹ lưỡng, mang đến hiệu năng vượt trội và phong cách đẳng cấp.
            </p>
        </div>

        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card h-100 shadow-sm border-0 transform-on-hover">
                    <div class="position-relative overflow-hidden rounded-top">
                        <img src="{{ asset('storage/' . $product['image']) }}" class="img-fluid" alt="{{ $product['name'] }}" style="object-fit: cover; height: 200px; width: 100%;">

                        @if(isset($product['badge']))
                        <span class="badge position-absolute top-0 start-0 m-2 fs-6
                                @if($product['badge'] === 'Sale') bg-danger
                                @elseif($product['badge'] === 'New') bg-success
                                @elseif($product['badge'] === 'Popular') bg-warning text-dark
                                @else bg-secondary
                                @endif" style="z-index: 1;">
                            {{ $product['badge'] }}
                        </span>
                        @endif

                        {{-- Wishlist Button --}}
                        <button class="btn btn-outline-danger rounded-circle p-2 position-absolute top-0 end-0 m-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title text-truncate mb-1">{{ $product['name'] }}</h5>

                        <div class="d-flex align-items-center mb-2">
                            <div class="rating-stars me-2 text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <=floor($product['rating']))
                                    <i class="bi bi-star-fill"></i>
                                    @elseif($i <= $product['rating'])
                                        <i class="bi bi-star-half"></i>
                                        @else
                                        <i class="bi bi-star"></i>
                                        @endif
                                        @endfor
                            </div>
                            <small class="text-muted">{{ $product['rating'] }} ({{ number_format($product['reviews']) }} đánh giá)</small>
                        </div>

                        @if(isset($product['features']))
                        <ul class="list-unstyled small text-muted mb-3 product-features">
                            @foreach($product['features'] as $feature)
                            <li><i class="bi bi-check-circle-fill text-success me-1"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        @endif

                        <div class="mb-3">
                            <span class="h4 fw-bolder text-primary">${{ number_format($product['price']) }}</span>
                            @if(isset($product['original_price']) && $product['original_price'] > $product['price'])
                            <span class="text-decoration-line-through text-muted ms-2">${{ number_format($product['original_price']) }}</span>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-primary w-100 py-2 d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-info-circle me-2"></i> Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

---

<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Tất Cả Điện Thoại</h2> {{-- Updated title to Vietnamese --}}
            <div class="d-flex align-items-center">
                <label for="sortSelect" class="form-label me-2 mb-0">Sắp xếp theo:</label> {{-- Added label --}}
                <select id="sortSelect" class="form-select" style="width: auto;">
                    <option value="">Mặc định</option> {{-- More neutral default option --}}
                    <option value="price_asc">Giá: Thấp đến Cao</option>
                    <option value="price_desc">Giá: Cao đến Thấp</option>
                    <option value="popular">Phổ biến nhất</option>
                    <option value="newest">Mới nhất</option>
                </select>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                {{-- Assuming 'product-card' partial exists and handles product display --}}
                @include('sanpham.product-card', ['product' => $product, 'showDetails' => true])
            </div>
            @endforeach
        </div>
        {{-- Add pagination if you have it for $products --}}
        {{-- <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
    </div> --}}
    </div>
</section>

---
@if ($recommended && $recommended->count() > 0)
<div class="recommendation-section">
    <h4 class="recommendation-title">Gợi ý dành riêng cho bạn</h4>
    
    <div class="recommendation-slider-container">
        <!-- Navigation Buttons -->
        <button class="recommendation-nav prev" id="prevBtn">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="recommendation-nav next" id="nextBtn">
            <i class="bi bi-chevron-right"></i>
        </button>
        
        <div class="recommendation-grid" id="recommendationGrid">
            @foreach ($recommended as $item)
            @if ($item->image)
            <div class="recommendation-card">
                {{-- Discount badge if applicable --}}
                @if ($item->gia_goc && $item->gia_goc > $item->gia_ban)
                <div class="discount-badge">
                    -{{ round((($item->gia_goc - $item->gia_ban) / $item->gia_goc) * 100) }}%
                </div>
                @endif
                
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->ten_san_pham }}">
                
                <div class="card-body">
                    <h6 class="card-title">{{ $item->ten_san_pham }}</h6>
                    
                    <div class="recommendation-price">{{ number_format($item->gia_ban) }}đ</div>
                    
                    @if ($item->gia_goc && $item->gia_goc > $item->gia_ban)
                    <div class="recommendation-original-price">{{ number_format($item->gia_goc) }}đ</div>
                    @endif
                    
                    <a href="{{ route('products.show', $item->slug) }}" class="recommendation-btn">
                        <i class="bi bi-eye me-2"></i>Xem chi tiết
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    
    <!-- Dots Indicator -->
    <div class="recommendation-dots" id="recommendationDots">
        <!-- Dots will be generated by JavaScript -->
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('recommendationGrid');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('recommendationDots');
    
    if (!grid || !prevBtn || !nextBtn) return;
    
    const cards = grid.querySelectorAll('.recommendation-card');
    const cardWidth = 280 + 24; // card width + gap
    const visibleCards = Math.floor(grid.parentElement.offsetWidth / cardWidth);
    const maxSlides = Math.max(0, cards.length - visibleCards);
    
    let currentSlide = 0;
    
    // Generate dots
    for (let i = 0; i <= maxSlides; i++) {
        const dot = document.createElement('button');
        dot.className = 'recommendation-dot';
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }
    
    const dots = dotsContainer.querySelectorAll('.recommendation-dot');
    
    function updateSlider() {
        const translateX = -currentSlide * cardWidth;
        grid.style.transform = `translateX(${translateX}px)`;
        
        // Update buttons
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide >= maxSlides;
        
        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }
    
    function goToSlide(slide) {
        currentSlide = Math.max(0, Math.min(slide, maxSlides));
        updateSlider();
    }
    
    prevBtn.addEventListener('click', () => {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (currentSlide < maxSlides) {
            currentSlide++;
            updateSlider();
        }
    });
    
    // Touch/swipe support
    let startX = 0;
    let isDragging = false;
    
    grid.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });
    
    grid.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
    });
    
    grid.addEventListener('touchend', (e) => {
        if (!isDragging) return;
        
        const endX = e.changedTouches[0].clientX;
        const diff = startX - endX;
        
        if (Math.abs(diff) > 50) {
            if (diff > 0 && currentSlide < maxSlides) {
                currentSlide++;
            } else if (diff < 0 && currentSlide > 0) {
                currentSlide--;
            }
            updateSlider();
        }
        
        isDragging = false;
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevBtn.click();
        } else if (e.key === 'ArrowRight') {
            nextBtn.click();
        }
    });
    
    // Initialize
    updateSlider();
    
    // Auto-play (optional)
    // setInterval(() => {
    //     if (currentSlide < maxSlides) {
    //         currentSlide++;
    //     } else {
    //         currentSlide = 0;
    //     }
    //     updateSlider();
    // }, 5000);
});
</script>
@endif


<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Cập Nhật Tin Tức Mới Nhất</h2> {{-- Updated title to Vietnamese --}}
        <p class="lead mb-4">Nhận thông báo về sản phẩm mới, ưu đãi độc quyền và tin tức công nghệ nóng hổi!</p> {{-- Updated description to Vietnamese --}}
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="d-flex gap-2">
                    <input type="email" class="form-control" placeholder="Nhập địa chỉ email của bạn"> {{-- Updated placeholder to Vietnamese --}}
                    <button type="submit" class="btn btn-light">Đăng Ký</button> {{-- Updated button text to Vietnamese --}}
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Initialize Swiper
    var swiper = new Swiper(".mySwiper", {
        loop: true, // Loop through slides
        autoplay: {
            delay: 5000, // 5 seconds
            disableOnInteraction: false, // Continue autoplay after user interaction
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

    // Animate.css integration (if used) - You'd need to include Animate.css link in your main layout
    // Example for the first slide (you might want to integrate this with Swiper's events for each slide)
    swiper.on('slideChangeTransitionEnd', function() {
        // Remove previous animations
        $('.animate__animated').removeClass('animate__fadeInLeft animate__zoomIn');
        // Add new animations to active slide content
        $('.swiper-slide-active .content').addClass('animate__animated animate__fadeInLeft');
        $('.swiper-slide-active .hero-phone').addClass('animate__animated animate__zoomIn');
    });

    // Initial animation for the first slide on page load
    $(document).ready(function() {
        $('.swiper-slide-active .content').addClass('animate__animated animate__fadeInLeft');
        $('.swiper-slide-active .hero-phone').addClass('animate__animated animate__zoomIn');
    });

    // Tooltip initialization (if you use tooltips on this page)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection