<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h2>Xin chào 👤 {{ $donHang->ten_nguoi_nhan }},</h2>

    <p>Chúng tôi đã tiếp nhận đơn hàng mã <strong>{{ $donHang->ma_don_hang }}</strong> 
    vào lúc {{ \Carbon\Carbon::parse($donHang->ngay_dat)->format('H:i d/m/Y') }}.</p>

    <ul>
        <li><strong>Sản phẩm đã đặt:</strong></li>
        <ul>
            @foreach ($donHang->chiTiet as $item)
                <li>
                    {{ $item->ten_san_pham }} |
                    Số Lượng {{ $item->so_luong }} 
                </li>
            @endforeach
        </ul>
        <li><strong>Phương thức thanh toán:</strong> {{ $donHang->phuong_thuc_thanh_toan }}</li>
        <li><strong>Tổng tiền:</strong> {{ number_format($donHang->thanh_toan) }}₫</li>
    </ul>

    <p>Chúng tôi sẽ gọi xác nhận đơn hàng trước khi đóng gói và giao hàng.</p>
    <p>Cảm ơn vì đã tin tưởng đồng hành cùng Fona_shop ❤️</p>

    <p>Trân trọng<br>Fona_shop</p>
</body>
</html>

