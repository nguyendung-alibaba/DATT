<select name="variants[{{ $index }}][size_id]">
    <option value="">Chọn kích cỡ</option>
    @foreach ($sizes as $size)
        <option value="{{ $size->id }}">{{ $size->name }}</option>
    @endforeach
</select>
