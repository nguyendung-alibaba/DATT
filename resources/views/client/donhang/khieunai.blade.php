@extends('client.layouts.app')

@section('title', 'Khiếu nại / Trả hàng')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Gửi khiếu nại đơn hàng #{{ $donHang->ma_don_hang }}</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('donhang.khieunai.submit', $donHang->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ly_do_khieu_nai" class="form-label">Lý do khiếu nại <span class="text-danger">*</span></label>
            <textarea name="ly_do_khieu_nai" class="form-control" rows="4" required>{{ old('ly_do_khieu_nai') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="phuong_thuc_hoan" class="form-label">Phương thức hoàn tiền (nếu có)</label>
            <select name="phuong_thuc_hoan" class="form-select">
                <option value="">-- Không hoàn tiền --</option>
                <option value="momo" {{ old('phuong_thuc_hoan') == 'momo' ? 'selected' : '' }}>Ví MoMo</option>
                <option value="bank" {{ old('phuong_thuc_hoan') == 'bank' ? 'selected' : '' }}>Chuyển khoản ngân hàng</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="stk_nguoi_nhan" class="form-label">Số tài khoản người nhận (nếu hoàn tiền)</label>
            <input type="text" name="stk_nguoi_nhan" class="form-control" value="{{ old('stk_nguoi_nhan') }}">
        </div>

        <button type="submit" class="btn btn-warning">Gửi khiếu nại</button>
        <a href="{{ route('client.donhang.show', $donHang->id) }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
