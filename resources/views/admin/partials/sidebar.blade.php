<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <i class="bi bi-shield-check text-warning"></i>
            <span class="brand-text">Admin Panel</span>
        </div>
        <button class="sidebar-toggle d-lg-none" onclick="toggleSidebar()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-content">
        <!-- User Profile Section -->
        <div class="sidebar-profile">
            <div class="profile-avatar">
                @auth
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff"
                    alt="Avatar" class="avatar-img">
                @else
                <i class="bi bi-person-circle"></i>
                @endauth
            </div>
            <div class="profile-info">
                @auth
                <h6 class="profile-name">{{ Auth::user()->name }}</h6>
                <small class="profile-role">{{ Auth::user()->role ?? 'Administrator' }}</small>
                @else
                <h6 class="profile-name">Guest User</h6>
                <small class="profile-role">Khách</small>
                @endauth
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin') || request()->is('admin/dashboard')) active @endif"
                        href="{{ route('admin.dashboard') ?? '/admin' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span class="nav-text">Dashboard</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-divider">
                    <span>QUẢN LÝ CHÍNH</span>
                </li>

                <!-- Quản lý Sản phẩm -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('sanpham*') || request()->is('admin/sanpham*')) active @endif"
                        href="{{ route('sanpham.index') ?? '/admin/sanpham' }}">
                        <i class="bi bi-box-seam"></i>
                        <span class="nav-text">Sản phẩm</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Quản lý Danh mục -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/danhmuc*')) active @endif"
                        href="/admin/danhmuc">
                        <i class="bi bi-tags"></i>
                        <span class="nav-text">Danh mục</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Quản lý Đơn hàng -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/don-hang*')) active @endif"
                        href="{{ route('don-hang.index') }}">
                        <i class="bi bi-cart-check"></i>
                        <span class="nav-text">Đơn hàng</span>
                        @if (isset($soDonHangChoXacNhan) && $soDonHangChoXacNhan > 0)
                        <span class="nav-badge badge bg-danger">
                            {{ $soDonHangChoXacNhan > 99 ? '99+' : $soDonHangChoXacNhan }}
                        </span>
                        @endif
                        <div class="nav-indicator"></div>
                    </a>
                </li>


                <!-- Divider -->
                <li class="nav-divider">
                    <span>KHÁCH HÀNG</span>
                </li>

                <!-- Quản lý Khách hàng -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/khachhang*')) active @endif"
                        href="/admin/khachhang">
                        <i class="bi bi-people"></i>
                        <span class="nav-text">Khách hàng</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Quản lý Voucher -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/voucher*')) active @endif"
                        href="{{ route('ma-giam-gia.index') }}">
                        <i class="bi bi-ticket-perforated"></i>
                        <span class="nav-text">Voucher</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-divider">
                    <span>HỆ THỐNG</span>
                </li>

                <!-- Quản lý Tài khoản -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/taikhoan*')) active @endif"
                        href="/admin/taikhoan">
                        <i class="bi bi-person-badge"></i>
                        <span class="nav-text">Tài khoản</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Thống kê & Báo cáo -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/baocao*')) active @endif"
                        href="/admin/baocao">
                        <i class="bi bi-bar-chart-line"></i>
                        <span class="nav-text">Báo cáo</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Cài đặt -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('admin/caidat*')) active @endif"
                        href="/admin/caidat">
                        <i class="bi bi-gear"></i>
                        <span class="nav-text">Cài đặt</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="footer-info">
            <small class="text-muted">Version 2.0.1</small>
        </div>
    </div>
</div>

<style>
    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
        color: #fff;
        z-index: 1000;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .sidebar-brand i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .brand-text {
        color: #fff;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.25rem;
        cursor: pointer;
    }

    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 0;
    }

    /* Profile Section */
    .sidebar-profile {
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        margin: 1rem;
        border-radius: 10px;
    }

    .profile-avatar {
        margin-right: 0.75rem;
    }

    .avatar-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-avatar i {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
    }

    .profile-role {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
    }

    /* Navigation */
    .sidebar-nav {
        padding: 0 1rem;
    }

    .sidebar-nav .nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 0.25rem;
        position: relative;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nav-link i {
        font-size: 1.1rem;
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }

    .nav-text {
        flex: 1;
        font-weight: 500;
    }

    .nav-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
    }

    .nav-indicator {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: var(--accent-color);
        border-radius: 0 3px 3px 0;
        transition: height 0.3s ease;
    }

    .nav-link:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .nav-link:hover .nav-indicator {
        height: 30px;
    }

    .nav-link.active {
        color: #fff;
        background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    }

    .nav-link.active .nav-indicator {
        height: 100%;
    }

    /* Dividers */
    .nav-divider {
        padding: 1rem 1rem 0.5rem;
        margin-top: 1rem;
    }

    .nav-divider span {
        font-size: 0.7rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Footer */
    .sidebar-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }
    }

    /* Collapsed Sidebar */
    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar.collapsed .brand-text,
    .sidebar.collapsed .nav-text,
    .sidebar.collapsed .nav-badge,
    .sidebar.collapsed .profile-info,
    .sidebar.collapsed .nav-divider span {
        display: none;
    }

    .sidebar.collapsed .sidebar-profile {
        justify-content: center;
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.75rem;
    }

    .sidebar.collapsed .nav-link i {
        margin-right: 0;
    }
</style>