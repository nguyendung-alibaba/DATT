@extends('client.layouts.app')

@section('title', $product['name'] . ' - SmartPhone Pro')

@section('content')

<div class="container py-5">
    <div class="row g-5 align-items-start">
        <div class="col-md-6">
            <!-- Main Product Image Container -->
            <div class="position-relative mb-4">
                <div class="card shadow-lg border-0 overflow-hidden rounded-3">
                    <img id="product-main-image" 
                         src="{{ asset('storage/' . $product['image']) }}" 
                         class="img-fluid w-100" 
                         alt="{{ $product['name'] }}" 
                         style="object-fit: cover; height: 500px; transition: all 0.3s ease;">
                </div>
                <!-- Zoom Effect Overlay -->
                <div class="position-absolute top-0 end-0 m-3">
                    <button class="btn btn-light btn-sm rounded-circle shadow" data-bs-toggle="tooltip" title="Phóng to">
                        <i class="bi bi-zoom-in"></i>
                    </button>
                </div>
            </div>
            
            <!-- Product Images Gallery -->
            @if(!empty($product['images']) && count($product['images']) > 1)
            <div class="mb-4" id="product-images-gallery">
                <h6 class="text-muted mb-3 fw-semibold">
                    <i class="bi bi-images me-2"></i>Hình ảnh sản phẩm
                </h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product['images'] as $index => $image)
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $image) }}"
                            alt="{{ $product['name'] }}"
                            class="img-thumbnail product-image-thumbnail {{ $index === 0 ? 'active' : '' }}"
                            data-main-image="{{ asset('storage/' . $image) }}"
                            style="width: 80px; 
                                   height: 80px; 
                                   object-fit: cover; 
                                   cursor: pointer; 
                                   border: 3px solid {{ $index === 0 ? '#0d6efd' : '#dee2e6' }};
                                   border-radius: 12px;
                                   transition: all 0.3s ease;
                                   box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Variant Images Gallery -->
            @if(!empty($product['variants']))
            <div class="mb-4" id="variant-images-gallery" style="display: none;">
                <h6 class="text-muted mb-3 fw-semibold">
                    <i class="bi bi-palette me-2"></i>Ảnh biến thể
                </h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product['variants'] as $variant)
                    @if(!empty($variant['thumbnail']))
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $variant['thumbnail']) }}"
                            alt="{{ $variant['color']['name'] ?? 'N/A' }} - {{ $variant['size']['name'] ?? 'N/A' }}"
                            class="img-thumbnail variant-thumbnail"
                            data-main-image="{{ asset('storage/' . $variant['thumbnail']) }}"
                            data-variant-id="{{ $variant['id'] }}"
                            style="width: 80px; 
                                   height: 80px; 
                                   object-fit: cover; 
                                   cursor: pointer; 
                                   border: 3px solid #dee2e6;
                                   border-radius: 12px;
                                   transition: all 0.3s ease;
                                   box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white text-center py-1" 
                             style="font-size: 10px; border-radius: 0 0 8px 8px;">
                            {{ substr($variant['color']['name'] ?? 'N/A', 0, 8) }}
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-6">
            <!-- Product Title -->
            <div class="mb-4">
                <h1 class="display-6 fw-bold text-dark mb-2">{{ $product['name'] }}</h1>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rating-stars fs-5">
                        @for($i = 0; $i < 5; $i++)
                            <i class="bi bi-star{{ $i < $product['rating'] ? '-fill text-warning' : ' text-muted' }}"></i>
                        @endfor
                    </div>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                        {{ $product['rating'] ?? 'N/A' }}/5 ⭐
                    </span>
                </div>
            </div>

            <!-- Price Section -->
            <div class="bg-light rounded-4 p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="display-5 fw-bold text-danger" id="display-price">
                        {{ number_format($product['price_after_discount'], 0, ',', '.') }}đ
                    </span>
                    @if($product['discount'])
                    <span class="badge bg-danger fs-6 rounded-pill px-3 py-2" id="display-discount">
                        -{{ $product['discount'] }}%
                    </span>
                    @endif
                </div>
                @if($product['discount'])
                <p class="fs-5 text-muted text-decoration-line-through mb-0" id="display-original-price">
                    {{ number_format($product['original_price'], 0, ',', '.') }}đ
                </p>
                @endif
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <h6 class="fw-semibold text-dark mb-3">
                    <i class="bi bi-info-circle me-2"></i>Mô tả sản phẩm
                </h6>
                <p class="text-secondary lh-lg">{{ $product['description'] }}</p>
            </div>

            <hr class="my-4">

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 shadow-sm">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Có lỗi xảy ra:</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Add to Cart Form -->
            <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                <input type="hidden" name="variant_id" id="selected-variant-id-input" value="">

                <!-- Variant Selection -->
                @if(!empty($product['variants']) && count($product['variants']) > 0)
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark d-block mb-3">
                        <i class="bi bi-palette me-2"></i>Chọn phiên bản:
                    </label>
                    <div class="row g-3" id="variant-options">
                        @foreach($product['variants'] as $variant)
                        <div class="col-md-6">
                            <div class="variant-option border rounded-3 p-3 h-100 position-relative" 
                                 style="cursor: pointer; transition: all 0.3s ease;">
                                <input class="form-check-input variant-radio position-absolute top-0 end-0 m-2"
                                    type="radio"
                                    name="variant_selection"
                                    id="variant-{{ $variant['id'] }}"
                                    value="{{ $variant['id'] }}"
                                    data-price="{{ $variant['price'] }}"
                                    data-original-price="{{ $variant['original_price'] ?? $product['original_price'] }}"
                                    data-discount="{{ $variant['discount'] ?? $product['discount'] }}"
                                    data-thumbnail="{{ asset('storage/' . ($variant['thumbnail'] ?? $product['image'])) }}"
                                    style="display: none;">
                                <label class="d-block w-100 h-100" for="variant-{{ $variant['id'] }}" style="cursor: pointer;">
                                    <div class="d-flex align-items-center gap-3">
                                        @if(!empty($variant['thumbnail']))
                                        <img src="{{ asset('storage/' . $variant['thumbnail']) }}" 
                                             class="rounded" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-semibold text-dark">
                                                {{ $variant['color']['name'] ?? 'N/A' }}
                                            </div>
                                            <div class="text-muted small">
                                                Size: {{ $variant['size']['name'] ?? 'N/A' }}
                                            </div>
                                            <div class="text-primary fw-bold">
                                                {{ number_format($variant['price'], 0, ',', '.') }}đ
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="alert alert-info border-0 rounded-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Sản phẩm này không có biến thể.
                </div>
                @endif

                <!-- Quantity Selection -->
                <div class="mb-4">
                    <label for="quantity" class="form-label fw-semibold text-dark">
                        <i class="bi bi-plus-minus me-2"></i>Số lượng
                    </label>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" 
                               class="form-control text-center" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-3">
                    <button type="submit" class="btn btn-success btn-lg rounded-3 shadow-sm">
                        <i class="bi bi-cart-plus me-2"></i> 
                        Thêm vào giỏ hàng
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg rounded-3">
                        <i class="bi bi-arrow-left-circle me-2"></i> 
                        Tiếp tục mua sắm
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const variantRadios = document.querySelectorAll('.variant-radio');
        const variantOptions = document.querySelectorAll('.variant-option');
        const selectedVariantInput = document.getElementById('selected-variant-id-input');
        const displayPrice = document.getElementById('display-price');
        const displayOriginalPrice = document.getElementById('display-original-price');
        const displayDiscount = document.getElementById('display-discount');
        const productMainImage = document.getElementById('product-main-image');
        const variantThumbnails = document.querySelectorAll('.variant-thumbnail');
        const productImageThumbnails = document.querySelectorAll('.product-image-thumbnail');
        const productImagesGallery = document.getElementById('product-images-gallery');
        const variantImagesGallery = document.getElementById('variant-images-gallery');

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Quantity controls
        window.decreaseQuantity = function() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        };

        window.increaseQuantity = function() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        };

        // Hàm để xóa border active từ tất cả thumbnails
        function clearAllActiveThumbnails() {
            document.querySelectorAll('.product-image-thumbnail, .variant-thumbnail').forEach(thumb => {
                thumb.style.border = '3px solid #dee2e6';
                thumb.classList.remove('active');
            });
        }

        // Hàm để set active cho thumbnail
        function setActiveThumbnail(thumbnail) {
            clearAllActiveThumbnails();
            thumbnail.style.border = '3px solid #0d6efd';
            thumbnail.classList.add('active');
        }

        // Clear variant selection styles
        function clearVariantSelection() {
            variantOptions.forEach(option => {
                option.style.border = '1px solid #dee2e6';
                option.style.backgroundColor = '';
                option.style.boxShadow = '';
            });
        }

        // Set variant selection style
        function setVariantSelection(option) {
            clearVariantSelection();
            option.style.border = '2px solid #0d6efd';
            option.style.backgroundColor = '#f8f9ff';
            option.style.boxShadow = '0 4px 12px rgba(13, 110, 253, 0.15)';
        }

        // Hàm reset giá về sản phẩm chính
        function resetPriceToOriginal() {
            displayPrice.innerHTML = `{{ number_format($product['price_after_discount'], 0, ',', '.') }}đ`;
            @if($product['discount'])
            if (displayOriginalPrice) {
                displayOriginalPrice.innerHTML = `{{ number_format($product['original_price'], 0, ',', '.') }}đ`;
                displayOriginalPrice.style.display = 'block';
            }
            if (displayDiscount) {
                displayDiscount.innerHTML = `-{{ $product['discount'] }}%`;
                displayDiscount.style.display = 'inline-block';
            }
            @else
            if (displayOriginalPrice) displayOriginalPrice.style.display = 'none';
            if (displayDiscount) displayDiscount.style.display = 'none';
            @endif
            clearVariantSelection();
        }

        // Hàm hiển thị gallery ảnh sản phẩm
        function showProductGallery() {
            if (productImagesGallery) productImagesGallery.style.display = 'block';
            if (variantImagesGallery) variantImagesGallery.style.display = 'none';
        }

        // Cập nhật ảnh, giá khi chọn biến thể
        function updateProductInfo(selectedVariant) {
            if (selectedVariant) {
                const price = parseFloat(selectedVariant.dataset.price);
                const originalPrice = parseFloat(selectedVariant.dataset.originalPrice) || 0;
                const discount = selectedVariant.dataset.discount;

                displayPrice.innerHTML = `${price.toLocaleString('vi-VN')}đ`;
                if (discount && originalPrice > price) {
                    if (displayOriginalPrice) {
                        displayOriginalPrice.innerHTML = `${originalPrice.toLocaleString('vi-VN')}đ`;
                        displayOriginalPrice.style.display = 'block';
                    }
                    if (displayDiscount) {
                        displayDiscount.innerHTML = `-${discount}%`;
                        displayDiscount.style.display = 'inline-block';
                    }
                } else {
                    if (displayOriginalPrice) displayOriginalPrice.style.display = 'none';
                    if (displayDiscount) displayDiscount.style.display = 'none';
                }

                const thumbnail = selectedVariant.dataset.thumbnail;
                if (thumbnail && productMainImage) {
                    productMainImage.src = thumbnail;
                }

                // Hiển thị gallery ảnh biến thể, ẩn gallery ảnh sản phẩm
                if (productImagesGallery) productImagesGallery.style.display = 'none';
                if (variantImagesGallery) variantImagesGallery.style.display = 'block';

                // Set active cho thumbnail biến thể tương ứng
                const correspondingThumbnail = document.querySelector(`.variant-thumbnail[data-variant-id="${selectedVariant.value}"]`);
                if (correspondingThumbnail) {
                    setActiveThumbnail(correspondingThumbnail);
                }

                // Set style cho variant option
                const variantOption = selectedVariant.closest('.variant-option');
                if (variantOption) {
                    setVariantSelection(variantOption);
                }
            } else {
                // Reset về sản phẩm chính - CHỈ KHI THỰC SỰ CẦN RESET
                resetPriceToOriginal();
                
                // CHỈ reset ảnh chính khi không có ảnh nào được chọn cụ thể
                if (productMainImage && !document.querySelector('.product-image-thumbnail.active')) {
                    productMainImage.src = `{{ asset('storage/' . $product['image']) }}`;
                }

                showProductGallery();

                // Set active cho ảnh chính của sản phẩm (ảnh đầu tiên) - CHỈ KHI KHÔNG CÓ ACTIVE
                if (!document.querySelector('.product-image-thumbnail.active')) {
                    const mainProductThumbnail = document.querySelector('.product-image-thumbnail');
                    if (mainProductThumbnail) {
                        setActiveThumbnail(mainProductThumbnail);
                    }
                }
            }
        }

        // Chọn lại biến thể cũ nếu có (khi bị redirect do lỗi)
        const oldVariantId = "{{ old('variant_id') }}";
        let matched = false;
        variantRadios.forEach(radio => {
            if (radio.value === oldVariantId) {
                radio.checked = true;
                selectedVariantInput.value = radio.value;
                updateProductInfo(radio);
                matched = true;
            }
        });

        // Nếu không có old('variant_id'), giữ nguyên hiển thị sản phẩm chính
        if (!matched) {
            updateProductInfo(null);
        }

        // Khi chọn biến thể thì cập nhật hidden input và ảnh/giá
        variantRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectedVariantInput.value = this.value;
                    updateProductInfo(this);
                }
            });
        });

        // Click variant option
        variantOptions.forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('.variant-radio');
                if (radio) {
                    radio.checked = true;
                    selectedVariantInput.value = radio.value;
                    updateProductInfo(radio);
                }
            });
        });

        // Click ảnh nhỏ của sản phẩm chính - ĐÃ SỬA LỖI
        productImageThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const mainImageSrc = this.dataset.mainImage;
                if (productMainImage && mainImageSrc) {
                    productMainImage.src = mainImageSrc;
                }
                setActiveThumbnail(this);

                // Bỏ chọn tất cả biến thể
                variantRadios.forEach(radio => radio.checked = false);
                selectedVariantInput.value = '';
                
                // Chỉ reset giá và hiển thị gallery, KHÔNG reset ảnh chính
                resetPriceToOriginal();
                showProductGallery();
            });
        });

        // Click ảnh nhỏ của biến thể
        variantThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const mainImageSrc = this.dataset.mainImage;
                const variantId = this.dataset.variantId;
                
                if (productMainImage && mainImageSrc) {
                    productMainImage.src = mainImageSrc;
                }
                setActiveThumbnail(this);

                // Chọn radio button tương ứng
                const radioToSelect = document.getElementById(`variant-${variantId}`);
                if (radioToSelect) {
                    radioToSelect.checked = true;
                    selectedVariantInput.value = variantId;
                    updateProductInfo(radioToSelect);
                }
            });
        });

        // Chặn submit nếu có biến thể nhưng chưa chọn
        document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
            const selectedVariant = selectedVariantInput.value;
            if (!selectedVariant && variantRadios.length > 0) {
                e.preventDefault();
                alert('Vui lòng chọn phiên bản sản phẩm trước khi thêm vào giỏ hàng.');
            }
        });

        // Hover effects for thumbnails
        document.querySelectorAll('.product-image-thumbnail, .variant-thumbnail').forEach(thumb => {
            thumb.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1.05)';
                    this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
                }
            });
            
            thumb.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1)';
                    this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                }
            });
        });
    });
</script>

<style>
    .variant-option:hover {
        border-color: #0d6efd !important;
        background-color: #f8f9ff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15) !important;
    }
    
    .product-image-thumbnail:hover,
    .variant-thumbnail:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
    
    .product-image-thumbnail.active,
    .variant-thumbnail.active {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
@endsection