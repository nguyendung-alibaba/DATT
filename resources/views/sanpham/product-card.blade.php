{{--
    Đây là file partial cho một thẻ sản phẩm.
    Nó được include từ các view khác, ví dụ:
    @include('sanpham.product-card', ['product' => $product, 'showDetails' => true])

    Biến $product dự kiến sẽ có cấu trúc:
    [
        'id' => ...,
        'name' => ...,
        'price' => ...,
        'original_price' => ...,
        'image' => ...,
        'slug' => ...,
        'rating' => ...,
        'reviews' => ...,
        'features' => [...],
        'badge' => ..., // Optional: 'Sale', 'New', 'Popular'
    ]
--}}
<div class="card product-card h-100">
    <div class="position-relative">
        {{-- Đường dẫn hình ảnh sản phẩm --}}
        <img src="{{ isset($product['image']) ? asset('storage/' . $product['image']) : 'https://placehold.co/400x300/e0e0e0/ffffff?text=No+Image' }}"
             class="img-fluid rounded"
             alt="{{ isset($product['name']) ? $product['name'] : 'Product Image' }}"
             onerror="this.onerror=null;this.src='https://placehold.co/400x300/e0e0e0/ffffff?text=No+Image';this.alt='No Image Available';">

        {{-- Hiển thị badge nếu có --}}
        @if(isset($product['badge']))
        <span class="badge badge-custom
            @if($product['badge'] === 'Sale') bg-danger
            @elseif($product['badge'] === 'New') bg-success
            @elseif($product['badge'] === 'Popular') bg-warning text-dark
            @else bg-secondary
            @endif">
            {{ $product['badge'] }}
        </span>
        @endif

        {{-- Nút yêu thích --}}
        <button class="btn btn-outline-light position-absolute" style="top: 10px; right: 10px; border-radius: 50%;">
            <i class="bi bi-heart"></i>
        </button>
    </div>

    <div class="card-body d-flex flex-column">
        {{-- Tên sản phẩm --}}
        <h5 class="card-title">{{ isset($product['name']) ? $product['name'] : 'Unknown Product' }}</h5>

        {{-- Đánh giá sao và số lượng review --}}
        @if(isset($product['rating']) && isset($product['reviews']))
        <div class="d-flex align-items-center mb-2">
            <div class="rating-stars me-2"> {{-- Màu sao được đặt trong CSS --}}
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($product['rating']))
                        <i class="bi bi-star-fill"></i>
                    @elseif($i <= $product['rating'])
                        <i class="bi bi-star-half"></i>
                    @else
                        <i class="bi bi-star"></i>
                    @endif
                @endfor
            </div>
            <small class="text-muted">{{ number_format($product['rating'], 1) }} ({{ number_format($product['reviews']) }} reviews)</small>
        </div>
        @endif

        {{-- Các tính năng sản phẩm --}}
        @if(isset($product['features']) && is_array($product['features']) && count($product['features']) > 0)
        <ul class="list-unstyled small text-muted mb-3">
            @foreach($product['features'] as $feature)
            <li>• {{ $feature }}</li>
            @endforeach
        </ul>
        @endif

        {{-- Giá sản phẩm --}}
        <div class="mb-3">
            @if(isset($product['price']))
            <span class="h4 fw-bold text-primary">${{ number_format($product['price']) }}</span>
            @endif
            @if(isset($product['original_price']) && isset($product['price']) && $product['original_price'] > $product['price'])
            <span class="price-original ms-2 text-decoration-line-through text-muted">${{ number_format($product['original_price']) }}</span>
            @endif
        </div>

        {{-- Nút xem chi tiết --}}
        <div class="mt-auto">
            @if(isset($product['slug']))
            <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-outline-primary w-100 rounded-pill">
                Xem chi tiết
            </a>
            @else
            {{-- Tùy chọn: hiển thị nút không hoạt động hoặc ẩn đi nếu không có slug --}}
            <button class="btn btn-outline-secondary w-100 rounded-pill" disabled>
                Không có chi tiết
            </button>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom styles for product card */
    .product-card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        height: 200px; /* Fixed height for consistent image display */
        object-fit: cover; /* Ensures image covers the area without distortion */
        border-top-left-radius: 0.25rem; /* Apply rounded corners to top */
        border-top-right-radius: 0.25rem; /* Apply rounded corners to top */
    }

    .badge-custom {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 0.4em 0.8em;
        font-size: 0.75em;
        border-radius: 0.3rem;
        z-index: 10;
    }

    .product-card .card-body {
        padding: 1rem;
    }

    .product-card .card-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        min-height: 50px; /* Ensure consistent height for titles */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limit to 2 lines */
        -webkit-box-orient: vertical;
    }

    .rating-stars .bi-star-fill,
    .rating-stars .bi-star-half,
    .rating-stars .bi-star {
        color: #ffc107; /* Màu vàng cho tất cả các sao, bao gồm sao rỗng để chúng hiển thị */
    }

    .price-original {
        font-size: 0.9em;
    }

    .btn-outline-primary {
        border-width: 2px;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-card img {
            height: 180px;
        }
        .product-card .card-title {
            font-size: 1rem;
            min-height: 48px;
        }
        .badge-custom {
            font-size: 0.7em;
            padding: 0.3em 0.6em;
        }
    }
</style>
<script>
    // Thêm sự kiện click cho nút yêu thích
    document.querySelectorAll('.product-card .btn-outline-light').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            // Xử lý logic yêu thích ở đây, ví dụ: gửi AJAX request để lưu trạng thái yêu thích
            // alert('Đã thêm vào yêu thích!'); // Thay thế alert bằng logic thực tế
            console.log('Nút yêu thích đã được nhấn!');
            // Ví dụ: Thay đổi icon khi được yêu thích
            const icon = this.querySelector('i.bi');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill'); // Giả sử bạn muốn một biểu tượng trái tim đầy
                this.classList.remove('btn-outline-light');
                this.classList.add('btn-danger'); // Thay đổi màu khi được yêu thích
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                this.classList.remove('btn-danger');
                this.classList.add('btn-outline-light');
            }
        });
    });
</script>