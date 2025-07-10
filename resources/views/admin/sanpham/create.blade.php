@extends('admin.layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Thêm sản phẩm mới</h1>
        <a href="{{ route('sanpham.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
    </div>

    {{-- Hiển thị một khối tổng hợp lỗi (nếu có) --}}
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

    <form action="{{ route('sanpham.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf
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
                            <input type="text" name="ten_san_pham" class="form-control @error('ten_san_pham') is-invalid @enderror" id="ten_san_pham" value="{{ old('ten_san_pham') }}">
                            @error('ten_san_pham')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="mo_ta_ngan" class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="mo_ta_ngan" class="form-control @error('mo_ta_ngan') is-invalid @enderror" id="mo_ta_ngan">{{ old('mo_ta_ngan') }}</textarea>
                            @error('mo_ta_ngan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="mo_ta_chi_tiet" class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea name="mo_ta_chi_tiet" class="form-control @error('mo_ta_chi_tiet') is-invalid @enderror" id="mo_ta_chi_tiet" rows="5">{{ old('mo_ta_chi_tiet') }}</textarea>
                            @error('mo_ta_chi_tiet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- GIÁ BÁN & TỒN KHO CHÍNH --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Giá & Tồn kho</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="gia_goc" class="form-label fw-bold">Giá gốc</label>
                                    <input type="number" name="gia_goc" min="0" class="form-control @error('gia_goc') is-invalid @enderror" id="gia_goc" value="{{ old('gia_goc', 0) }}">
                                    @error('gia_goc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="gia_ban" class="form-label fw-bold">Giá bán *</label>
                                    <input type="number" name="gia_ban" min="0" class="form-control @error('gia_ban') is-invalid @enderror" id="gia_ban" value="{{ old('gia_ban') }}">
                                    @error('gia_ban')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="so_luong_ton" class="form-label fw-bold">Tồn kho chính</label>
                                    <input type="number" name="so_luong_ton" min="0" class="form-control @error('so_luong_ton') is-invalid @enderror" id="so_luong_ton" value="{{ old('so_luong_ton', 0) }}">
                                     @error('so_luong_ton')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <small class="form-text text-muted">Giá & Tồn kho chính sẽ được áp dụng nếu sản phẩm không có biến thể nào.</small>
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
                            {{-- Tự động hiển thị lại các biến thể đã nhập nếu validation lỗi --}}
                            @if(is_array(old('variants')))
                                @foreach(old('variants') as $index => $oldVariant)
                                    <div class="variant-item mb-3 border p-3 position-relative">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-3 mb-2">
                                                <label class="form-label">Màu sắc</label>
                                                <select class="form-select @error('variants.'.$index.'.color_id') is-invalid @enderror" name="variants[{{ $index }}][color_id]">
                                                    <option value="">-- Chọn màu --</option>
                                                    @foreach($colors as $color)
                                                        <option value="{{ $color->id }}" @selected(isset($oldVariant['color_id']) && $oldVariant['color_id'] == $color->id)>{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('variants.'.$index.'.color_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6 col-lg-3 mb-2">
                                                <label class="form-label">Kích thước</label>
                                                <select class="form-select @error('variants.'.$index.'.size_id') is-invalid @enderror" name="variants[{{ $index }}][size_id]">
                                                    <option value="">-- Chọn size --</option>
                                                    @foreach($sizes as $size)
                                                        <option value="{{ $size->id }}" @selected(isset($oldVariant['size_id']) && $oldVariant['size_id'] == $size->id)>{{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('variants.'.$index.'.size_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6 col-lg-3 mb-2">
                                                <label class="form-label">Giá</label>
                                                <input type="number" class="form-control @error('variants.'.$index.'.price') is-invalid @enderror" name="variants[{{ $index }}][price]" value="{{ $oldVariant['price'] ?? '' }}">
                                                @error('variants.'.$index.'.price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6 col-lg-3 mb-2">
                                                <label class="form-label">Số lượng</label>
                                                <input type="number" class="form-control @error('variants.'.$index.'.quantity') is-invalid @enderror" name="variants[{{ $index }}][quantity]" value="{{ $oldVariant['quantity'] ?? '' }}">
                                                @error('variants.'.$index.'.quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Ảnh biến thể</label>
                                                <input type="file" class="form-control @error('variants.'.$index.'.thumbnail') is-invalid @enderror" name="variants[{{ $index }}][thumbnail]" accept="image/*">
                                                @error('variants.'.$index.'.thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger position-absolute remove-variant" style="top: 10px; right: 10px;" onclick="this.closest('.variant-item').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
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
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($danhmucs as $dm)
                                    <option value="{{ $dm->category_id }}" @selected(old('category_id') == $dm->category_id)>{{ $dm->ten_danh_muc }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="brand_id" class="form-label fw-bold">Thương hiệu</label>
                            <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach($thuonghieus as $th)
                                    <option value="{{ $th->brand_id }}" @selected(old('brand_id') == $th->brand_id)>{{ $th->ten_thuong_hieu }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ẢNH SẢN PHẨM --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ảnh sản phẩm chính *</h5>
                    </div>
                    <div class="card-body">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="mt-3 text-center">
                            <img id="image-preview" src="#" alt="Ảnh xem trước" style="display:none; max-width: 100%; max-height: 200px; border-radius: 5px;">
                        </div>
                    </div>
                    
                </div>
                <label>Ảnh phụ:</label>
                <input type="file" name="extra_images[]" multiple class="form-control" accept="image/*">
                {{-- TRẠNG THÁI & LƯU --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Trạng thái & Lưu</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured'))>
                            <label class="form-check-label" for="is_featured">Sản phẩm nổi bật</label>
                        </div>
                         <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_bestseller" value="1" id="is_bestseller" @checked(old('is_bestseller'))>
                            <label class="form-check-label" for="is_bestseller">Sản phẩm bán chạy</label>
                        </div>
                        <hr>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="radio" name="trang_thai" id="status_active" value="1" @checked(old('trang_thai', 1) == 1)>
                            <label class="form-check-label" for="status_active">Hiển thị</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="radio" name="trang_thai" id="status_inactive" value="0" @checked(old('trang_thai', 1) == 0)>
                            <label class="form-check-label" for="status_inactive">Ẩn</label>
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu sản phẩm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .variant-item:last-child { margin-bottom: 0 !important; }
    .invalid-feedback { display: block !important; }
</style>
@endpush

@section('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('image-preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        if (event.target.files.length > 0) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Bắt đầu index từ số lượng biến thể cũ nếu có lỗi validation
    let variantIndex = {{ is_array(old('variants')) ? count(old('variants')) : 0 }};

    function addVariant() {
        const container = document.getElementById('variants-container');
        // Sử dụng timestamp để đảm bảo index là duy nhất và không bị trùng
        const index = 'new_' + Date.now(); 

        const variantTemplate = `
            <div class="variant-item mb-3 border p-3 position-relative">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-2">
                        <label class="form-label">Màu sắc</label>
                        <select class="form-select" name="variants[${index}][color_id]">
                            <option value="">-- Chọn màu --</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-2">
                        <label class="form-label">Kích thước</label>
                        <select class="form-select" name="variants[${index}][size_id]">
                            <option value="">-- Chọn size --</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-2">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" name="variants[${index}][price]" placeholder="Giá biến thể">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-2">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" name="variants[${index}][quantity]" placeholder="Số lượng">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Ảnh biến thể</label>
                        <input type="file" class="form-control" name="variants[${index}][thumbnail]" accept="image/*">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger position-absolute remove-variant" style="top: 10px; right: 10px;" onclick="this.closest('.variant-item').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>`;
        
        container.insertAdjacentHTML('beforeend', variantTemplate);
    }
    
    document.getElementById('add-variant-btn').addEventListener('click', addVariant);

    // Tự động thêm một biến thể ban đầu nếu chưa có dữ liệu cũ
    document.addEventListener('DOMContentLoaded', function() {
        if (variantIndex === 0) {
            addVariant();
        }
    });
</script>
@endsection