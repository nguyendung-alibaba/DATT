@extends('admin.layouts.admin')

@section('title', 'Kiểm tra Blockchain')

@section('content')
    <h3>🧱 Trạng thái Blockchain:</h3>
    <p>
        <strong>{{ $valid ? '✅ Chuỗi hợp lệ' : '❌ Chuỗi bị thay đổi!' }}</strong>
    </p>

    @if ($blocks->isEmpty())
        <div class="alert alert-warning">⛔ Chưa có block nào được ghi nhận.</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Đơn hàng</th>
                <th>Previous Hash</th>
                <th>Current Hash</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blocks as $block)
            <tr>
                <td>{{ $block->id }}</td>
                <td>#{{ $block->don_hang_id }}</td>
                <td>{{ $block->previous_hash }}</td>
                <td>{{ $block->current_hash }}</td>
                <td>#{{ $block->don_hang_id }}</td>
{{-- Hoặc nếu bạn muốn hiển thị thêm thông tin chi tiết đơn --}}
{{-- <td>{{ $block->donHang->ten_nguoi_nhan ?? 'N/A' }}</td> --}}
                <td>{{ $block->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        // Tự động làm mới trang sau 5 giây
        setTimeout(() => {
            window.location.reload();
        }, 5000);
    </script>
@endsection