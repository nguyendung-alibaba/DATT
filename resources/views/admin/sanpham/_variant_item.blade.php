<div class="variant-item mb-3 border p-3">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Màu sắc</label>
                <select class="form-control" name="variants[{{$index}}][color_id]">
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}"
                            {{ (isset($variant) && $variant->color_id == $color->id) ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Kích thước</label>
                <select class="form-control" name="variants[{{$index}}][size_id]">
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}"
                            {{ (isset($variant) && $variant->size_id == $size->id) ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Giá</label>
                <input type="number" class="form-control" name="variants[{{$index}}][price]"
                    value="{{ $variant->price ?? '' }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" class="form-control" name="variants[{{$index}}][quantity]"
                    value="{{ $variant->quantity ?? '' }}">
            </div>
        </div>
    </div>
    <div class="variant-header mt-2">
        <span class="remove-variant" style="color: #dc3545; cursor: pointer;"><i class="fas fa-trash"></i> Xóa</span>
    </div>
</div>
