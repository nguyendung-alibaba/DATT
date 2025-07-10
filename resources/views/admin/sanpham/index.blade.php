@extends('admin.layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Danh sách sản phẩm</h2>
    <a href="{{ route('sanpham.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
    </a>
</div>

<div class="content-card">
    <div class="content-card-body table-responsive">
        <table class="table table-bordered align-middle table-hover">
            <thead class="table-light text-center">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Danh mục</th>
                    <th>Thương hiệu</th>
                    <th>Ảnh Sản Phẩm Chính</th> {{-- Changed label for clarity --}}
                    <th>Giá gốc</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Biến thể</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sanphams as $sp)
                <tr>
                    <td class="text-center">{{ $sp->product_id }}</td>
                    <td>{{ $sp->ten_san_pham }}</td>
                    <td>{{ $sp->danhMuc->ten_danh_muc ?? '-' }}</td>
                    <td>{{ $sp->thuongHieu->ten_thuong_hieu ?? '-' }}</td>
                    <td class="text-center">
                        @if($sp->image)
                            <img src="{{ asset('storage/' . $sp->image) }}" alt="Ảnh chính" style="width: 70px; height: auto; object-fit: cover;">
                        @else
                            <small>Không có ảnh</small>
                        @endif
                    </td>
                    <td>{{ number_format($sp->gia_goc) }}₫</td>
                    <td>{{ number_format($sp->gia_ban) }}₫</td>
                    <td class="text-center">{{ $sp->so_luong_ton }}</td>
                    <td>
                        <div style="max-height: 200px; overflow-y: auto;"> {{-- Increased max-height for variants section --}}
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th>Ảnh</th> {{-- New column for variant thumbnail --}}
                                        <th>Màu</th>
                                        <th>Size</th>
                                        <th>Giá</th>
                                        <th>SL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sp->variants as $v)
                                    <tr>
                                        <td class="text-center">
                                            @if($v->thumbnail)
                                                <img src="{{ asset('storage/' . $v->thumbnail) }}" alt="Ảnh biến thể" style="width: 50px; height: auto; object-fit: cover;">
                                            @else
                                                <small>Không có</small>
                                            @endif
                                        </td>
                                        <td>{{ $v->color->name ?? '' }}</td>
                                        <td>{{ $v->size->name ?? '' }}</td>
                                        <td>{{ number_format($v->price) }}₫</td>
                                        <td>{{ $v->quantity }}</td>
                                    </tr>
                                    @endforeach
                                    @if($sp->variants->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Không có biến thể nào.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('sanpham.show', $sp->product_id) }}" class="btn btn-info btn-sm mb-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('sanpham.edit', $sp->product_id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('sanpham.destroy', $sp->product_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection