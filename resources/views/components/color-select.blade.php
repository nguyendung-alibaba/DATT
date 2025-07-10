<select name="variants[{{ $index }}][color_id]">
    <option value="">Chọn màu sắc</option>
    @foreach ($colors as $color)
        <option value="{{ $color->id }}">{{ $color->name }}</option>
    @endforeach
</select>
