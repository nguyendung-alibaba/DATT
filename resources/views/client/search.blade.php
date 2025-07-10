@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
    <div class="container py-5">
        <h2>Kết quả cho: "{{ $query }}"</h2>

        @if($results->count())
            <div class="row g-4 mt-4">
                @foreach($results as $product)
                    <div class="col-md-4">
                        <div class="card product-card h-100">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="text-danger fw-bold">{{ number_format($product->price_after_discount) }}đ</p>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mt-4">Không tìm thấy sản phẩm nào.</p>
        @endif
    </div>
@endsection
