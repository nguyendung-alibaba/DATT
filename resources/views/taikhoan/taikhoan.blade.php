@extends('layouts.admin')
@section('title', 'Quản lý tài khoản')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh sách tài khoản</h4>
    <a href="#" class="btn btn-primary"><i class="bi bi-plus"></i> Thêm tài khoản</a>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" class="text-center text-muted">Chưa có dữ liệu tài khoản.</td>
        </tr>
    </tbody>
</table>
@endsection
