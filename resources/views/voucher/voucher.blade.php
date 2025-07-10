@extends('layouts.admin')
@section('title', 'Quản lý voucher')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh sách voucher</h4>
    <a href="#" class="btn btn-primary"><i class="bi bi-plus"></i> Thêm voucher</a>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã voucher</th>
            <th>Mô tả</th>
            <th>Giá trị (%)</th>
            <th>Ngày hết hạn</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7" class="text-center text-muted">Chưa có dữ liệu voucher.</td>
        </tr>
    </tbody>
</table>
@endsection
