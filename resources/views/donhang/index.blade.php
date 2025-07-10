@extends('layouts.admin')
@section('title', 'Quản lý Đơn hàng')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh sách đơn hàng</h4>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã đơn hàng</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" class="text-center text-muted">Chưa có dữ liệu đơn hàng.</td>
        </tr>
    </tbody>
</table>
@endsection
