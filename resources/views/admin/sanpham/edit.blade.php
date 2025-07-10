@extends('admin.layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Chỉnh sửa sản phẩm: {{ $sanpham->ten_san_pham }}</h1>
        <a href="{{ route('sanpham.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
    </div>

    {{-- HIỂN THỊ MỘT KHỐI TỔNG HỢP LỖI (NẾU CÓ) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Rất tiếc, đã có lỗi xảy ra:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sanpham.update', $sanpham->product_id) }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf
        @method('PUT')
        <div class="row">
            {{-- ======================================================= --}}
            {{-- ======================= CỘT TRÁI ======================= --}}
            {{-- ======================================================= --}}
            <div class="col-lg-8">
                {{-- THÔNG TIN CƠ BẢN --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin cơ bản</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="ten_san_pham" class="form-label fw-bold">Tên sản phẩm *</label>
                            <input type="text" name="ten_san_pham" class="form-control @error('ten_san_pham') is-invalid @enderror" id="ten_san_pham" value="{{ old('ten_san_pham', $sanpham->ten_san_pham) }}" required>
                            @error('ten_san_pham')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="mo_ta_ngan" class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="mo_ta_ngan" class="form-control @error('mo_ta_ngan') is-invalid @enderror" id="mo_ta_ngan">{{ old('mo_ta_ngan', $sanpham->mo_ta_ngan) }}</textarea>
                             @error('mo_ta_ngan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="mo_ta_chi_tiet" class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea name="mo_ta_chi_tiet" class="form-control @error('mo_ta_chi_tiet') is-invalid @enderror" id="mo_ta_chi_tiet" rows="5">{{ old('mo_ta_chi_tiet', $sanpham->mo_ta_chi_tiet) }}</textarea>
                             @error('mo_ta_chi_tiet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- GIÁ BÁN --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Giá bán</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="gia_goc" class="form-label fw-bold">Giá gốc</label>
                                    <input type="number" name="gia_goc" min="0" class="form-control @error('gia_goc') is-invalid @enderror" id="gia_goc" value="{{ old('gia_goc', $sanpham->gia_goc) }}">
                                     @error('gia_goc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="gia_ban" class="form-label fw-bold">Giá bán *</label>
                                    <input type="number" name="gia_ban" min="0" required class="form-control @error('gia_ban') is-invalid @enderror" id="gia_ban" value="{{ old('gia_ban', $sanpham->gia_ban) }}">
                                     @error('gia_ban')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BIẾN THỂ SẢN PHẨM --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Biến thể sản phẩm</h5>
                        <button type="button" class="btn btn-sm btn-light" id="add-variant-btn">
                            <i class="fas fa-plus"></i> Thêm biến thể
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variants-container">
                            @foreach($sanpham->variants as $index => $variant)
                                <div class="variant-item mb-3 border p-3 bg-light position-relative">
                                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    <div class="row">
                                        {{-- MÀU SẮC --}}
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Màu sắc</label>
                                            <select class="form-select @error('variants.'.$index.'.color_id') is-invalid @enderror" name="variants[{{ $index }}][color_id]">
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}" @selected($variant->color_id == $color->id)>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('variants.'.$index.'.color_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- KÍCH THƯỚC --}}
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Kích thước</label>
                                            <select class="form-select @error('variants.'.$index.'.size_id') is-invalid @enderror" name="variants[{{ $index }}][size_id]">
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}" @selected($variant->size_id == $size->id)>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                             @error('variants.'.$index.'.size_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- GIÁ --}}
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Giá</label>
                                            <input type="number" class="form-control @error('variants.'.$index.'.price') is-invalid @enderror" name="variants[{{ $index }}][price]" value="{{ old('variants.'.$index.'.price', $variant->price) }}">
                                             @error('variants.'.$index.'.price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- SỐ LƯỢNG --}}
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number" class="form-control @error('variants.'.$index.'.quantity') is-invalid @enderror" name="variants[{{ $index }}][quantity]" value="{{ old('variants.'.$index.'.quantity', $variant->quantity) }}">
                                             @error('variants.'.$index.'.quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- HÌNH ẢNH --}}
                                        <div class="col-12">
                                            <label class="form-label">Hình ảnh biến thể</label>
                                            <input type="file" class="form-control @error('variants.'.$index.'.thumbnail') is-invalid @enderror" name="variants[{{ $index }}][thumbnail]" accept="image/*">
                                            <input type="hidden" name="variants[{{ $index }}][current_thumbnail]" value="{{ $variant->thumbnail }}">
                                             @error('variants.'.$index.'.thumbnail')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            @if($variant->thumbnail)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $variant->thumbnail) }}" alt="Ảnh hiện tại" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                                    <small class="d-block text-muted">Chọn file mới để thay thế ảnh này.</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger position-absolute remove-variant" style="top: 10px; right: 10px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- ======================= CỘT PHẢI ======================= --}}
            {{-- ======================================================== --}}
            <div class="col-lg-4">
                {{-- DANH MỤC & THƯƠNG HIỆU --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Phân loại</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label fw-bold">Danh mục *</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($danhmucs as $dm)
                                    <option value="{{ $dm->category_id }}" @selected(old('category_id', $sanpham->category_id) == $dm->category_id)>
                                        {{ $dm->ten_danh_muc }}
                                    </option>
                                @endforeach
                            </select>
                             @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="brand_id" class="form-label fw-bold">Thương hiệu</label>
                            <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach($thuonghieus as $th)
                                    <option value="{{ $th->brand_id }}" @selected(old('brand_id', $sanpham->brand_id) == $th->brand_id)>
                                        {{ $th->ten_thuong_hieu }}
                                    </option>
                                @endforeach
                            </select>
                             @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ẢNH SẢN PHẨM --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ảnh sản phẩm chính</h5>
                    </div>
                    <div class="card-body">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                         @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-3 text-center">
                            @if($sanpham->image)
                                <img id="image-preview" src="{{ asset('storage/' . $sanpham->image) }}" alt="Ảnh xem trước" style="max-width: 100%; max-height: 200px; border-radius: 5px;">
                            @else
                                <img id="image-preview" src="#" alt="Ảnh xem trước" style="display:none; max-width: 100%; max-height: 200px; border-radius: 5px;">
                            @endif
                        </div>
                    </div>
                </div>
                    <label>Ảnh phụ:</label>
                <input type="file" name="extra_images[]" multiple class="form-control" accept="image/*">

                {{-- TRẠNG THÁI & NÚT SUBMIT --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Trạng thái</h5>
                    </div>
                    <div class="card-body">
                         <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="radio" name="trang_thai" id="status_active" value="1" @checked(old('trang_thai', $sanpham->trang_thai) == 1)>
                            <label class="form-check-label" for="status_active">Hiển thị</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="radio" name="trang_thai" id="status_inactive" value="0" @checked(old('trang_thai', $sanpham->trang_thai) == 0)>
                            <label class="form-check-label" for="status_inactive">Ẩn</label>
                        </div>
                        @error('trang_thai')
                           <div class="text-danger small mt-1">{{ $message }}</div>
                       @enderror
                        <hr>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật sản phẩm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    .variant-item:last-child { margin-bottom: 0 !important; }
    /* Giúp invalid-feedback hiển thị đúng ngay cả khi input nằm trong group */
    .form-group .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('scripts')
{{-- Thêm các thư viện cần thiết --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
{{-- JavaScript không cần thay đổi --}}
<script>
    // Hàm xem trước ảnh chính
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('image-preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Hàm khởi tạo sự kiện cho một item biến thể
    function initVariantEvents(variantElement) {
        variantElement.querySelector('.remove-variant').addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn xóa biến thể này?')) {
                variantElement.remove();
            }
        });
    }

    // Thêm biến thể mới
    document.getElementById('add-variant-btn').addEventListener('click', function() {
        const container = document.getElementById('variants-container');
        const index = 'new_' + Date.now(); 

        const variantTemplate = `
            <div class="variant-item mb-3 border p-3 position-relative">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Màu sắc</label>
                        <select class="form-select" name="variants[${index}][color_id]">
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Kích thước</label>
                        <select class="form-select" name="variants[${index}][size_id]">
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" name="variants[${index}][price]" placeholder="Giá biến thể">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" name="variants[${index}][quantity]" placeholder="Số lượng biến thể">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Hình ảnh biến thể</label>
                        <input type="file" class="form-control" name="variants[${index}][thumbnail]" accept="image/*">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger position-absolute remove-variant" style="top: 10px; right: 10px;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>`;
        
        container.insertAdjacentHTML('beforeend', variantTemplate);
        initVariantEvents(container.lastElementChild);
    });

    // Gắn sự kiện cho các biến thể đã có khi tải trang
    document.querySelectorAll('.variant-item').forEach(initVariantEvents);
</script>
@endsection