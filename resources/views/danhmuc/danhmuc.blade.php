@extends('layouts.admin')
@section('title', 'Quản lý danh mục')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh mục sản phẩm</h4>
    <a href="#" class="btn btn-primary"><i class="bi bi-plus"></i> Thêm danh mục</a>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5" class="text-center text-muted">Chưa có dữ liệu danh mục.</td>
        </tr>
    </tbody>
</table>
@endsection
