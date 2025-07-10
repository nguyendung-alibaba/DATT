@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="fas fa-box text-primary me-2"></i>
                Chi tiết sản phẩm
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sanpham.index') }}">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">{{ $sanpham->ten_san_pham }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('sanpham.edit', $sanpham->product_id) }}" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-edit me-1"></i>Chỉnh sửa
            </a>
            <a href="{{ route('sanpham.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Quay lại
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Thay thế phần ảnh hiện tại bằng code này để test -->
<div class="col-lg-5">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body p-4">
            <!-- Ảnh chính -->
            @if($sanpham->image)
            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $sanpham->image) }}"
                    class="img-fluid rounded-3 shadow-sm product-image"
                    style="max-height: 400px; object-fit: cover; width: 100%; cursor: pointer;"
                    alt="{{ $sanpham->ten_san_pham }}" 
                    id="mainProductImage">
            </div>
            @else
            <div class="text-center py-5 mb-4">
                <i class="fas fa-image text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">Chưa có hình ảnh chính</p>
            </div>
            @endif

            <!-- Ảnh phụ - Version đơn giản -->
            @if(($sanpham->images && count($sanpham->images)) || $sanpham->image)
            <div class="mt-2 text-center">
                <h6 class="text-muted small fw-bold mb-2">ẢNH PHỤ</h6>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    
                    <!-- Ảnh chính như thumbnail -->
                    @if($sanpham->image)
                    <img src="{{ asset('storage/' . $sanpham->image) }}"
                        class="img-thumbnail shadow-sm secondary-image-thumbnail"
                        style="width: 100px; height: 100px; object-fit: cover; cursor: pointer; border: 2px solid #ddd;"
                        alt="Ảnh chính" 
                        data-full-image="{{ asset('storage/' . $sanpham->image) }}">
                    @endif

                    <!-- Các ảnh phụ -->
                    @forelse($sanpham->images as $index => $img)
                    <img src="{{ asset('storage/' . $img->image_path) }}"
                        class="img-thumbnail shadow-sm secondary-image-thumbnail"
                        style="width: 100px; height: 100px; object-fit: cover; cursor: pointer; border: 2px solid #ddd;"
                        alt="Ảnh phụ {{ $index + 1 }}" 
                        data-full-image="{{ asset('storage/' . $img->image_path) }}">
                    @empty
                        @if(!$sanpham->image)
                            <p class="text-muted small mb-0">Không có ảnh phụ</p>
                        @endif
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin sản phẩm
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">ID SẢN PHẨM</label>
                                <div class="fw-semibold">#{{ $sanpham->product_id }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">TÊN SẢN PHẨM</label>
                                <div class="fw-semibold text-primary">{{ $sanpham->ten_san_pham }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">DANH MỤC</label>
                                <div>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $sanpham->danhMuc->ten_danh_muc ?? 'Chưa phân loại' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">THƯƠNG HIỆU</label>
                                <div>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-award me-1"></i>
                                        {{ $sanpham->thuongHieu->ten_thuong_hieu ?? 'Chưa có' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">GIÁ GỐC</label>
                                <div class="h5 text-muted text-decoration-line-through">
                                    {{ number_format($sanpham->gia_goc) }}₫
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">GIÁ BÁN</label>
                                <div class="h4 text-danger fw-bold">
                                    {{ number_format($sanpham->gia_ban) }}₫
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">TỒN KHO</label>
                                <div>
                                    <span class="badge {{ $sanpham->so_luong_ton > 10 ? 'bg-success' : ($sanpham->so_luong_ton > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        <i class="fas fa-boxes me-1"></i>
                                        {{ $sanpham->so_luong_ton }} sản phẩm
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small fw-bold">TRẠNG THÁI</label>
                                <div>
                                    <span class="badge {{ $sanpham->trang_thai ? 'bg-success' : 'bg-secondary' }}">
                                        <i class="fas {{ $sanpham->trang_thai ? 'fa-eye' : 'fa-eye-slash' }} me-1"></i>
                                        {{ $sanpham->trang_thai ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-item">
                                <label class="form-label text-muted small fw-bold">TÍNH NĂNG</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge {{ $sanpham->is_featured ? 'bg-info' : 'bg-light text-dark' }}">
                                        <i class="fas fa-star me-1"></i>
                                        {{ $sanpham->is_featured ? 'Nổi bật' : 'Không nổi bật' }}
                                    </span>
                                    <span class="badge {{ $sanpham->is_bestseller ? 'bg-warning text-dark' : 'bg-light text-dark' }}">
                                        <i class="fas fa-fire me-1"></i>
                                        {{ $sanpham->is_bestseller ? 'Bán chạy' : 'Không bán chạy' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($sanpham->mo_ta_ngan || $sanpham->mo_ta_chi_tiet)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-align-left me-2"></i>
                        Mô tả sản phẩm
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($sanpham->mo_ta_ngan)
                    <div class="mb-4">
                        <h6 class="text-muted small fw-bold mb-2">MÔ TẢ NGẮN</h6>
                        <div class="border-start border-primary border-3 ps-3">
                            <p class="mb-0">{{ $sanpham->mo_ta_ngan }}</p>
                        </div>
                    </div>
                    @endif

                    @if($sanpham->mo_ta_chi_tiet)
                    <div>
                        <h6 class="text-muted small fw-bold mb-2">MÔ TẢ CHI TIẾT</h6>
                        <div class="border-start border-info border-3 ps-3">
                            <div class="product-description">{!! $sanpham->mo_ta_chi_tiet !!}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-success text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-palette me-2"></i>
                        Biến thể sản phẩm
                    </h5>
                    @if($sanpham->variants && count($sanpham->variants))
                    <span class="badge bg-light text-dark">
                        {{ count($sanpham->variants) }} biến thể
                    </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($sanpham->variants && count($sanpham->variants))
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 text-muted fw-bold small text-center">
                                        <i class="fas fa-image me-1"></i>HÌNH ẢNH
                                    </th>
                                    <th class="border-0 text-muted fw-bold small">
                                        <i class="fas fa-palette me-1"></i>MÀU SẮC
                                    </th>
                                    <th class="border-0 text-muted fw-bold small">
                                        <i class="fas fa-ruler me-1"></i>KÍCH CỠ
                                    </th>
                                    <th class="border-0 text-muted fw-bold small">
                                        <i class="fas fa-tag me-1"></i>GIÁ
                                    </th>
                                    <th class="border-0 text-muted fw-bold small">
                                        <i class="fas fa-boxes me-1"></i>SỐ LƯỢNG
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sanpham->variants as $variant)
                                <tr>
                                    <td class="align-middle text-center">
                                        @if($variant->thumbnail)
                                        <img src="{{ asset('storage/' . $variant->thumbnail) }}" class="variant-thumbnail" alt="Ảnh biến thể">
                                        @else
                                        <div class="variant-thumbnail-placeholder">
                                            <i class="fas fa-camera text-muted"></i>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark border">
                                            {{ $variant->color->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark border">
                                            {{ $variant->size->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="fw-bold text-primary">
                                            {{ number_format($variant->price) }}₫
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge {{ $variant->quantity > 10 ? 'bg-success' : ($variant->quantity > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ $variant->quantity }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-palette text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-0">Chưa có biến thể nào cho sản phẩm này</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-warning text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Bình luận & Đánh giá
                    </h5>
                    {{-- Giả sử bạn có quan hệ 'comments' trong model SanPham --}}
                    @if(isset($sanpham->comments) && count($sanpham->comments))
                    <span class="badge bg-light text-dark">
                        {{ count($sanpham->comments) }} bình luận
                    </span>
                    @else
                    <span class="badge bg-light text-dark">0 bình luận</span>
                    @endif
                </div>
                <div class="card-body p-4">
                    {{-- Statistics Row --}}
                    <div class="row mb-4">
                        {{-- Placeholder for statistics --}}
                        @php
                            $totalRatings = 0;
                            $averageRating = 0;
                            $ratingCounts = array_fill(1, 5, 0); // Initialize counts for 1 to 5 stars

                            if (isset($sanpham->comments) && count($sanpham->comments) > 0) {
                                foreach ($sanpham->comments as $comment) {
                                    if ($comment->rating >= 1 && $comment->rating <= 5) {
                                        $ratingCounts[$comment->rating]++;
                                        $totalRatings += $comment->rating;
                                    }
                                }
                                $averageRating = count($sanpham->comments) > 0 ? $totalRatings / count($sanpham->comments) : 0;
                            }
                        @endphp
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded-3 shadow-sm h-100 d-flex flex-column justify-content-center">
                                <h2 class="display-4 fw-bold text-primary mb-0">{{ number_format($averageRating, 1) }}</h2>
                                <div class="text-warning mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($averageRating))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">{{ count($sanpham->comments ?? []) }} đánh giá</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="p-3 bg-light rounded-3 shadow-sm h-100">
                                @for ($i = 5; $i >= 1; $i--)
                                    @php
                                        $percentage = count($sanpham->comments ?? []) > 0 ? ($ratingCounts[$i] / count($sanpham->comments)) * 100 : 0;
                                    @endphp
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="small text-muted me-2">{{ $i }} <i class="fas fa-star text-warning"></i></span>
                                        <div class="progress flex-grow-1" style="height: 10px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="small text-muted ms-2">{{ $ratingCounts[$i] }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Comments List --}}
                    <div class="comments-section mt-4">
                        <h6 class="text-muted small fw-bold mb-3">DANH SÁCH BÌNH LUẬN</h6>
                        @forelse(($sanpham->comments ?? collect())->sortByDesc('created_at') as $comment)
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong class="text-primary">{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</strong>
                                        <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $comment->rating)
                                                <i class="fas fa-star small"></i>
                                            @else
                                                <i class="far fa-star small"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0 text-dark">{{ $comment->comment_text }}</p>
                            </div>
                        </div>
                        @empty
                        {{-- Empty State --}}
                        <div class="text-center py-5">
                            <i class="fas fa-comments text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Chưa có bình luận nào</h5>
                            <p class="text-muted mb-0">Sản phẩm này chưa có bình luận hoặc đánh giá từ khách hàng</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Image Display (Lightbox) --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Xem ảnh sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-fluid rounded shadow" id="modalImage" alt="Ảnh sản phẩm">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Gradient Backgrounds */
    .bg-gradient-primary { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); }

    /* Card Styling */
    .card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden; /* Ensure content respects border-radius */
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .card-header {
        border-bottom: none;
        border-radius: 12px 12px 0 0; /* Match card border-radius */
    }

    /* Product Image & Thumbnails */
    .product-image {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05); /* subtle border */
    }
    .product-image:hover {
        transform: scale(1.02); /* Slightly less aggressive scale for main image */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .img-thumbnail {
        border-radius: 8px;
        object-fit: cover;
        padding: 0.25rem;
        background-color: #fff;
    }

    /* Secondary Image Thumbnails */
    .secondary-image-thumbnail {
        border: 2px solid transparent; /* default border */
        transition: border-color 0.2s ease, transform 0.2s ease;
    }
    .secondary-image-thumbnail:hover {
        border-color: #007bff; /* highlight on hover */
        transform: translateY(-2px);
    }
    .secondary-image-thumbnail.active {
        border-color: #007bff; /* highlight active image */
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25); /* Subtle glow for active */
    }

    /* Info Items */
    .info-item {
        padding: 0.75rem 1rem;
        background-color: #f8f9fa;
        border-left: 4px solid #e9ecef; /* Subtle left border */
        border-radius: 8px;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }
    .info-item:hover {
        background-color: #e2e6ea;
        border-color: #ced4da;
    }
    .info-item label {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
        color: #6c757d;
    }
    .info-item div {
        font-size: 1rem;
        color: #343a40;
    }
    .info-item .text-primary { color: #007bff !important; }
    .info-item .text-danger { color: #dc3545 !important; }

    /* Badges */
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.8em;
        border-radius: 6px;
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
    }
    .badge.border {
        border-width: 1px !important;
    }
    .badge .fas {
        font-size: 0.7em; /* Smaller icon in badge */
        vertical-align: middle;
        margin-top: -1px;
    }

    /* Tables */
    .table th {
        font-size: 0.8rem; /* Slightly smaller for table headers */
        letter-spacing: 0.5px;
        text-transform: uppercase;
        vertical-align: middle;
        border-bottom: 2px solid #e9ecef;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.95rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f2f2f2;
    }

    /* Variant Thumbnails */
    .variant-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 2px;
    }
    .variant-thumbnail-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background-color: #e9ecef;
        border: 1px solid #dee2e6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #adb5bd;
    }

    /* Breadcrumbs */
    .breadcrumb-item+.breadcrumb-item::before {
        color: #6c757d;
    }

    /* Modal Styling */
    #imageModal .modal-content {
        border-radius: 12px;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.3);
    }
    #modalImage {
        max-height: 80vh; /* Limit modal image height */
        width: auto;
        display: block; /* Center image */
        margin: auto; /* Center image */
    }
    .modal-header .btn-close {
        font-size: 0.9rem;
    }
    .modal-footer {
        border-top: none;
    }

    /* Product Description (for rich text) */
    .product-description img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 10px 0;
    }
    .product-description table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
    }
    .product-description th, .product-description td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .product-description ul, .product-description ol {
        padding-left: 20px;
    }
    .product-description p {
        margin-bottom: 1rem;
    }

    /* Comments Section */
    .comments-section .card {
        margin-bottom: 1rem;
        border-left: 4px solid #ffc107; /* Highlight comment cards */
    }
    .comments-section .card-body {
        padding: 1rem;
    }
    .comments-section .text-warning .fas,
    .comments-section .text-warning .far {
        font-size: 0.8rem;
    }
    .progress {
        height: 8px !important;
        border-radius: 5px;
    }
    .progress-bar {
        transition: width 0.6s ease;
    }
</style>

@section('scripts')
<script>
$(document).ready(function() {
    console.log('--- Script loaded: jQuery version ---'); // Dòng này giúp xác nhận script đã chạy

    // Lắng nghe sự kiện click trên các ảnh thumbnail
    $('.secondary-image-thumbnail').on('click', function() {
        console.log('Thumbnail clicked!'); // Kiểm tra: Dòng này có xuất hiện khi click không?

        var newImageSrc = $(this).data('full-image'); // Lấy đường dẫn ảnh lớn từ thuộc tính data-full-image
        console.log('New image src:', newImageSrc); // Kiểm tra: Đường dẫn này có đúng không?

        if (newImageSrc) {
            // Đổi thuộc tính src của ảnh chính
            $('#mainProductImage').attr('src', newImageSrc);
            console.log('Main image src updated to:', $('#mainProductImage').attr('src')); // Xác nhận: Src của ảnh chính đã đổi

            // Xóa trạng thái active của tất cả thumbnails
            $('.secondary-image-thumbnail').removeClass('active');
            // Thêm trạng thái active cho thumbnail vừa click
            $(this).addClass('active');
        } else {
            console.log('Error: newImageSrc is empty or null.');
        }
    });

    // Thiết lập ảnh thumbnail active ban đầu khi trang tải
    var initialMainSrc = $('#mainProductImage').attr('src');
    if (initialMainSrc) {
        $('.secondary-image-thumbnail').each(function() {
            if ($(this).data('full-image') === initialMainSrc) {
                $(this).addClass('active');
                return false; // Thoát vòng lặp
            }
        });
    }
});
</script>
@endsection
@endsection