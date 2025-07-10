@extends('client.layouts.app')

@section('title', 'Giỏ hàng của bạn - SmartPhone Pro')

@section('styles')
<style>
    .cart-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    }

    .cart-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .custom-alert {
        border: none;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-left: 4px solid;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left-color: #28a745;
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border-left-color: #dc3545;
        color: #721c24;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        border-left-color: #17a2b8;
        color: #0c5460;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-cart-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .cart-actions {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .cart-table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .modern-table {
        margin-bottom: 0;
        border: none;
    }

    .modern-table thead th {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        color: white;
        border: none;
        padding: 1.2rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f8f9fa;
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .modern-table tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border: none;
    }

    .product-info {
        font-weight: 600;
        color: #495057;
    }

    .variant-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        padding: 0.5rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        color: #1976d2;
        display: inline-block;
    }

    .price-text {
        font-weight: 600;
        color: #28a745;
        font-size: 1.1rem;
    }

    .quantity-input {
        width: 80px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .quantity-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }

    .total-price {
        font-weight: 700;
        color: #dc3545;
        font-size: 1.2rem;
    }

    .delete-btn {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
    }

    .delete-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    }

    .total-row {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-top: 3px solid #6366f1 !important;
    }

    .total-row td {
        padding: 1.5rem 1rem !important;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .btn-modern {
        border: none;
        border-radius: 12px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
    }

    .btn-primary-modern:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #7c3aed 100%);
        color: white;
    }

    .btn-success-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-success-modern:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
    }

    .btn-secondary-modern {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }

    .btn-secondary-modern:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        color: white;
    }

    .btn-danger-modern {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-danger-modern:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
    }

    .bottom-actions {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 1rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    @media (max-width: 991.98px) {
        .cart-header {
            text-align: center;
            padding: 1.5rem;
        }
        
        .cart-actions {
            text-align: center;
        }
        
        .cart-actions .d-flex {
            flex-direction: column;
            gap: 1rem;
        }
        
        .bottom-actions .d-flex {
            flex-direction: column;
            gap: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .modern-table {
            font-size: 0.85rem;
        }
        
        .modern-table th,
        .modern-table td {
            padding: 0.8rem 0.5rem !important;
        }
        
        .variant-info {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }
        
        .btn-modern {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="cart-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="cart-icon">
                    🛒
                </div>
                <h2 class="mb-2 fw-bold">Giỏ hàng của bạn</h2>
                <p class="mb-0 opacity-75">Quản lý và xem lại các sản phẩm bạn đã chọn</p>
            </div>
            @if(!$items->isEmpty())
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $items->count() }}</div>
                    <div class="stats-label">Sản phẩm trong giỏ</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($items->isEmpty())
        <div class="alert alert-info custom-alert">
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h4>Giỏ hàng của bạn đang trống</h4>
                <p class="mb-3">Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary-modern btn-modern">
                    <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
    @else
        <!-- Cart Actions -->
        <div class="cart-actions">
            <div class="d-flex justify-content-between align-items-center">
                <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-modern btn-modern">
                        <i class="fas fa-trash-alt me-2"></i>Xóa toàn bộ giỏ hàng
                    </button>
                </form>

                <!-- <a href="{{ route('checkout.show') }}" class="btn btn-success-modern btn-modern">
                    <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                </a> -->
            </div>
        </div>

        {{-- FORM CẬP NHẬT GIỎ --}}
        <form method="POST" action="{{ route('cart.update_all') }}">
            @csrf
            @method('PUT')

            <div class="cart-table-container">
                <table class="table modern-table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Sản phẩm</th>
                            <th class="text-center">Phiên Bản</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Thành tiền</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td class="text-center">
                                <div class="fw-bold text-primary">{{ $loop->iteration }}</div>
                            </td>
                            <td>
                                <div class="product-info">{{ $item->product->ten_san_pham ?? '[Đã xóa]' }}</div>
                            </td>
                            <td class="text-center">
                                <div class="variant-info">
                                    <i class="fas fa-palette me-1"></i>{{ $item->variant->color->name ?? 'N/A' }}
                                    <br>
                                    <i class="fas fa-expand-arrows-alt me-1"></i>{{ $item->variant->size->name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="price-text">{{ number_format($item->don_gia, 0, ',', '.') }}₫</div>
                            </td>
                            <td class="text-center">
                                <input type="number" name="quantities[{{ $item->cart_item_id }}]" value="{{ $item->so_luong }}"
                                    min="1" class="form-control quantity-input">
                            </td>
                            <td class="text-center">
                                <div class="total-price">{{ number_format($item->don_gia * $item->so_luong, 0, ',', '.') }}₫</div>
                            </td>
                            <td class="text-center">
                                <button type="submit" form="delete-form-{{ $item->cart_item_id }}" class="delete-btn"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                    <i class="fas fa-trash me-1"></i>Xóa
                                </button>
                            </td>
                        </tr>
                        @endforeach

                        <tr class="total-row">
                            <td colspan="5" class="text-end">
                                <i class="fas fa-calculator me-2"></i>Tổng tiền:
                            </td>
                            <td colspan="2" class="text-center">
                                <div class="total-price" style="font-size: 1.5rem;">{{ number_format($tong_tien, 0, ',', '.') }}₫</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bottom-actions">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary-modern btn-modern">
                        <i class="fas fa-sync-alt me-2"></i>Cập nhật giỏ hàng
                    </button>

                    <div class="d-flex gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary-modern btn-modern">
                            <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                        </a>
                        <a href="{{ route('checkout.show') }}" class="btn btn-success-modern btn-modern">
                            <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </form>

        {{-- FORM XÓA RIÊNG --}}
        @foreach($items as $item)
        <form id="delete-form-{{ $item->cart_item_id }}" method="POST" action="{{ route('cart.destroy', $item->cart_item_id) }}">
            @csrf
            @method('DELETE')
        </form>
        @endforeach
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Smooth scroll to top when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Add some interactive effects
        const tableRows = document.querySelectorAll('.modern-table tbody tr:not(.total-row)');
        
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Auto-save quantity changes (optional enhancement)
        const quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                // You could add auto-save functionality here if needed
                this.style.borderColor = '#28a745';
                setTimeout(() => {
                    this.style.borderColor = '#e9ecef';
                }, 1000);
            });
        });
    });
</script>
@endsection