@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm biến thể cho: {{ $sanpham->ten_san_pham }}</h1>
    <form action="{{ route('variant.store', $sanpham->product_id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>SKU</label>
            <input type="text" name="ma_sku" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giá gốc</label>
            <input type="number" step="0.01" name="gia_goc" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giá bán</label>
            <input type="number" step="0.01" name="gia_ban" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tồn kho</label>
            <input type="number" name="so_luong_ton" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Thuộc tính (Chọn giá trị thuộc tính cho biến thể)</label>
            @foreach($attributes as $attribute)
                <div>
                    <label>{{ $attribute->ten_thuoc_tinh }}</label>
                    <select name="attributes[{{ $attribute->attribute_id }}]" class="form-control">
                        @foreach($attribute->values as $value)
                            <option value="{{ $value->attribute_value_id }}">{{ $value->gia_tri }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-success">Lưu biến thể</button>
    </form>
</div>
@endsection
