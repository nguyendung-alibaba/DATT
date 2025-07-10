@extends('admin.layouts.admin')

@section('title', 'Dashboard - Trang quản trị')

@section('css')
<style>
    .stats-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .chart-container {
        height: 400px;
    }

    .recent-activity {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }

    .activity-item:hover {
        background-color: #f8fafc;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 1rem;
    }

    .progress-sm {
        height: 6px;
    }
</style>
@endsection

@section('content')
@php
$pageTitle = 'Dashboard';
$pageSubtitle = 'Tổng quan về hệ thống quản trị';
$breadcrumbs = [
['title' => 'Dashboard', 'url' => '/admin']
];
@endphp

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary me-3">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Đơn hàng hôm nay</h6>
                        <h3 class="mb-0">156</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +12.5%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Doanh thu hôm nay</h6>
                        <h3 class="mb-0">45.8M</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +8.2%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning me-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Khách hàng mới</h6>
                        <h3 class="mb-0">24</h3>
                        <small class="text-danger">
                            <i class="bi bi-arrow-down"></i> -3.2%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info me-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Sản phẩm tồn kho</h6>
                        <h3 class="mb-0">1,245</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +5.7%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Sales Chart -->
    <div class="col-xl-8">
        <div class="card border-0 h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Doanh thu 7 ngày gần đây</h5>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Tuần này
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Tuần này</a></li>
                        <li><a class="dropdown-item" href="#">Tháng này</a></li>
                        <li><a class="dropdown-item" href="#">Quý này</a></li>
                        <li><a class="dropdown-item" href="#">Năm nay</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-xl-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">Sản phẩm bán chạy</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>iPhone 15 Pro Max</span>
                        <span>256</span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Samsung Galaxy S23 Ultra</span>
                        <span>189</span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 55%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Xiaomi 13 Pro</span>
                        <span>132</span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Oppo Find X5 Pro</span>
                        <span>98</span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 30%"></div>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Vivo X90 Pro</span>
                        <span>76</span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities & Orders -->
<div class="row g-4">
    <!-- Recent Activities -->
    <div class="col-xl-6">
        <div class="card border-0 h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hoạt động gần đây</h5>
                <a href="/admin/activities" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <div class="activity-item d-flex">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff"
                            alt="Avatar" class="activity-avatar">
                        <div>
                            <h6 class="mb-1">Admin đã thêm sản phẩm mới</h6>
                            <p class="mb-1 text-muted">iPhone 15 Pro Max 256GB</p>
                            <small class="text-muted">10 phút trước</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <img src="https://ui-avatars.com/api/?name=Nguyen+Van+A&background=10b981&color=fff"
                            alt="Avatar" class="activity-avatar">
                        <div>
                            <h6 class="mb-1">Nguyễn Văn A đã đặt hàng</h6>
                            <p class="mb-1 text-muted">Đơn hàng #DH-2023-0125</p>
                            <small class="text-muted">25 phút trước</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <img src="https://ui-avatars.com/api/?name=Tran+Thi+B&background=ef4444&color=fff"
                            alt="Avatar" class="activity-avatar">
                        <div>
                            <h6 class="mb-1">Trần Thị B đã hủy đơn hàng</h6>
                            <p class="mb-1 text-muted">Đơn hàng #DH-2023-0124</p>
                            <small class="text-muted">1 giờ trước</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <img src="https://ui-avatars.com/api/?name=Manager&background=f59e0b&color=fff"
                            alt="Avatar" class="activity-avatar">
                        <div>
                            <h6 class="mb-1">Manager đã cập nhật kho hàng</h6>
                            <p class="mb-1 text-muted">Nhập 50 sản phẩm Samsung S23</p>
                            <small class="text-muted">2 giờ trước</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <img src="https://ui-avatars.com/api/?name=Le+Van+C&background=8b5cf6&color=fff"
                            alt="Avatar" class="activity-avatar">
                        <div>
                            <h6 class="mb-1">Lê Văn C đã đánh giá sản phẩm</h6>
                            <p class="mb-1 text-muted">5 sao cho iPhone 14 Pro</p>
                            <small class="text-muted">3 giờ trước</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-xl-6">
        <div class="card border-0 h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Đơn hàng mới nhất</h5>
                <a href="/admin/donhang" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#DH-2023-0125</td>
                                <td>Nguyễn Văn A</td>
                                <td>25.990.000đ</td>
                                <td><span class="badge bg-primary">Chờ xử lý</span></td>
                            </tr>
                            <tr>
                                <td>#DH-2023-0124</td>
                                <td>Trần Thị B</td>
                                <td>18.750.000đ</td>
                                <td><span class="badge bg-danger">Đã hủy</span></td>
                            </tr>
                            <tr>
                                <td>#DH-2023-0123</td>
                                <td>Lê Văn C</td>
                                <td>32.450.000đ</td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                            </tr>
                            <tr>
                                <td>#DH-2023-0122</td>
                                <td>Phạm Thị D</td>
                                <td>15.990.000đ</td>
                                <td><span class="badge bg-warning">Đang giao</span></td>
                            </tr>
                            <tr>
                                <td>#DH-2023-0121</td>
                                <td>Hoàng Văn E</td>
                                <td>22.350.000đ</td>
                                <td><span class="badge bg-info">Đang xử lý</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
            datasets: [{
                label: 'Doanh thu (VND)',
                data: [12500000, 18900000, 15200000, 23400000, 27800000, 32100000, 28900000],
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            }
        }
    });

    // Update charts on theme change
    document.addEventListener('themeChanged', function() {
        salesChart.update();
    });

    // Auto update data (simulated)
    setInterval(() => {
        // Simulate data update
        const newData = salesChart.data.datasets[0].data.map(value => {
            const change = Math.floor(Math.random() * 1000000) - 500000;
            return Math.max(5000000, value + change);
        });

        salesChart.data.datasets[0].data = newData;
        salesChart.update();
    }, 10000);
</script>
@endsection