<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang quản trị')</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #f8fafc;
            --accent-color: #fbbf24;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --sidebar-width: 280px;
            --navbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--secondary-color);
            color: var(--text-dark);
            overflow-x: hidden;
            margin: 0 !important;
            padding: 0 !important;
            position: relative !important;
        }

        /* Loading Animation */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: var(--sidebar-width) !important;
            height: 100vh !important;
            background: #1e293b !important;
            color: white !important;
            z-index: 1000 !important;
            transition: all 0.3s ease !important;
            overflow-y: auto !important;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1) !important;
        }

        .sidebar.collapsed {
            width: 70px !important;
        }

        /* Navbar Styles */
        .admin-navbar,
        .navbar-top {
            position: fixed !important;
            top: 0 !important;
            left: var(--sidebar-width) !important;
            right: 0 !important;
            height: var(--navbar-height) !important;
            background: white !important;
            border-bottom: 1px solid var(--border-color) !important;
            z-index: 999 !important;
            transition: left 0.3s ease !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 1rem !important;
        }

        .sidebar.collapsed ~ .admin-wrapper .admin-navbar,
        .sidebar.collapsed ~ .admin-wrapper .navbar-top {
            left: 70px !important;
        }

        /* Main Layout */
        .admin-wrapper {
            display: flex;
            /* min-height: 100vh; */
            position: relative;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width) !important;
            padding-top: var(--navbar-height) !important;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width)) !important;
            position: relative !important;
        }

        .main-content.expanded {
            margin-left: 70px !important;
            width: calc(100% - 70px) !important;
        }

        .content-area {
            padding: 2rem !important;
            min-height: calc(100vh - var(--navbar-height)) !important;
            position: relative !important;
            z-index: 1 !important;
        }

        /* Breadcrumb */
        .breadcrumb-container {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-light);
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-light);
            margin-bottom: 0;
        }

        /* Content Card */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .content-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            background: #fafbfc;
        }

        .content-card-body {
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px !important;
            }
            
            .main-content {
                margin-left: 70px !important;
                width: calc(100% - 70px) !important;
            }
            
            .admin-navbar,
            .navbar-top {
                left: 70px !important;
            }
            
            .content-area {
                padding: 1rem !important;
            }
            
            .page-header {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 0 !important;
                transform: translateX(-100%) !important;
            }
            
            .sidebar.show {
                width: var(--sidebar-width) !important;
                transform: translateX(0) !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .admin-navbar,
            .navbar-top {
                left: 0 !important;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
    
    @yield('css')
</head>

<body>
    <!-- Loading Screen -->
    <div class="loading" id="loading">
        <div class="loading-spinner"></div>
    </div>

    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Include Sidebar -->
    @include('admin.partials.sidebar')

    <div class="admin-wrapper">
        <!-- Include Navbar -->
        @include('admin.partials.navbar')

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Breadcrumb -->
            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
            <div class="breadcrumb-container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
            @endif
            
            <!-- Content Area -->
            <div class="content-area">
                <!-- Page Header -->
                @if(isset($pageTitle) || isset($pageSubtitle))
                <div class="page-header fade-in">
                    @if(isset($pageTitle))
                        <h1 class="page-title">{{ $pageTitle }}</h1>
                    @endif
                    @if(isset($pageSubtitle))
                        <p class="page-subtitle">{{ $pageSubtitle }}</p>
                    @endif
                </div>
                @endif
                
                <!-- Main Content -->
                <div class="fade-in">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    @include('admin.partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // Hide loading screen
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.style.display = 'none';
            }
        });

        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (!sidebar || !mainContent) {
                console.warn('Sidebar or main content not found');
                return;
            }
            
            // For mobile
            if (window.innerWidth <= 576) {
                sidebar.classList.toggle('show');
                if (overlay) {
                    overlay.classList.toggle('show');
                }
            } else {
                // For desktop/tablet
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Close sidebar when clicking overlay
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    toggleSidebar();
                });
            }

            // Active link highlighting
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
            
            sidebarLinks.forEach(link => {
                if (link && link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth > 576) {
                if (sidebar) {
                    sidebar.classList.remove('show');
                }
                if (overlay) {
                    overlay.classList.remove('show');
                }
            }
        });

        // Toast notifications
        function showToast(message, type = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: type,
                    title: message
                });
            } else {
                console.log(`${type.toUpperCase()}: ${message}`);
            }
        }

        // Make toggleSidebar globally available
        window.toggleSidebar = toggleSidebar;
        window.showToast = showToast;
    </script>
    @yield('scripts')
</body>
</html>