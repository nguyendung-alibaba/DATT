<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" id="topNavbar">
    <div class="container-fluid">
        <button class="navbar-toggler border-0 d-lg-none" type="button" onclick="toggleSidebar()" aria-label="Toggle sidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <form class="navbar-search d-none d-md-flex" role="search">
            <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Tìm kiếm sản phẩm, đơn hàng..." autocomplete="off">
                <div class="search-suggestions" id="searchSuggestionsDesktop">
                    </div>
            </div>
        </form>

        <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
            <div class="nav-item d-md-none me-3">
                <button class="nav-link btn btn-link" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Open search">
                    <i class="bi bi-search fs-5"></i>
                </button>
            </div>
            
            <div class="nav-item dropdown me-3">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-circle me-1"></i> Thêm mới
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('sanpham.create') ?? '#' }}"><i class="bi bi-box me-2"></i>Sản phẩm</a></li>
                    <li><a class="dropdown-item" href="/admin/danhmuc/create"><i class="bi bi-tags me-2"></i>Danh mục</a></li>
                    <li><a class="dropdown-item" href="{{ route('ma-giam-gia.create') ?? '#' }}"><i class="bi bi-ticket me-2"></i>Voucher</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/admin/khachhang/create"><i class="bi bi-person-plus me-2"></i>Khách hàng</a></li>
                </ul>
            </div>

            <div class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Unread messages">
                    <i class="bi bi-chat-dots fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">2<span class="visually-hidden">tin nhắn chưa đọc</span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end message-dropdown">
                    <div class="dropdown-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Tin nhắn</h6>
                        <a href="#" class="text-primary small">Đánh dấu đã đọc</a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item message-item unread" href="#"><img src="https://ui-avatars.com/api/?name=A" class="message-avatar" alt="Avatar"><div class="message-content"><div class="message-name">Nguyễn Văn A</div><div class="message-text">Khi nào có hàng iPhone 15?</div><div class="message-time">10 phút trước</div></div></a>
                    <a class="dropdown-item message-item unread" href="#"><img src="https://ui-avatars.com/api/?name=B" class="message-avatar" alt="Avatar"><div class="message-content"><div class="message-name">Trần Thị B</div><div class="message-text">Đơn hàng của tôi thế nào rồi?</div><div class="message-time">1 giờ trước</div></div></a>
                    <a class="dropdown-item message-item" href="#"><img src="https://ui-avatars.com/api/?name=C" class="message-avatar" alt="Avatar"><div class="message-content"><div class="message-name">Lê Văn C</div><div class="message-text">Cảm ơn shop đã hỗ trợ!</div><div class="message-time">3 giờ trước</div></div></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-center text-primary" href="/admin/tinnhan">Xem tất cả tin nhắn</a>
                </div>
            </div>

            <div class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Unread notifications">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">5<span class="visually-hidden">thông báo chưa đọc</span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                    <div class="dropdown-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Thông báo</h6>
                        <a href="#" class="text-primary small">Đánh dấu đã đọc</a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item notification-item unread" href="#"><div class="notification-icon bg-primary"><i class="bi bi-cart-check text-white"></i></div><div class="notification-content"><div class="notification-title">Đơn hàng mới</div><div class="notification-text">Có 3 đơn hàng mới cần xử lý</div><div class="notification-time">5 phút trước</div></div></a>
                    <a class="dropdown-item notification-item" href="#"><div class="notification-icon bg-warning"><i class="bi bi-exclamation-triangle text-white"></i></div><div class="notification-content"><div class="notification-title">Sản phẩm hết hàng</div><div class="notification-text">iPhone 15 Pro sắp hết hàng</div><div class="notification-time">1 giờ trước</div></div></a>
                    <a class="dropdown-item notification-item" href="#"><div class="notification-icon bg-success"><i class="bi bi-person-check text-white"></i></div><div class="notification-content"><div class="notification-title">Khách hàng mới</div><div class="notification-text">5 khách hàng mới đăng ký</div><div class="notification-time">2 giờ trước</div></div></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-center text-primary" href="/admin/messages">Xem tất cả thông báo</a>
                </div>
            </div>

            <div class="nav-item me-3">
                <button class="nav-link btn btn-link" id="darkModeToggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chế độ Sáng/Tối">
                    <i class="bi bi-moon fs-5"></i>
                </button>
            </div>

            <div class="nav-item me-3 d-none d-md-block">
                <button class="nav-link btn btn-link" id="fullscreenToggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toàn màn hình">
                    <i class="bi bi-fullscreen fs-5"></i>
                </button>
            </div>

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @auth
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" alt="Avatar" class="user-avatar me-2">
                    <span class="user-name d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    @else
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <span class="user-name d-none d-lg-inline">Guest</span>
                    @endauth
                </a>
                <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                    @auth
                    <li class="dropdown-header">
                        <div class="user-info">
                            <div class="user-name-header">{{ Auth::user()->name }}</div>
                            <div class="user-email">{{ Auth::user()->email }}</div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/admin/profile"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
                    <li><a class="dropdown-item" href="/admin/settings"><i class="bi bi-gear me-2"></i>Cài đặt tài khoản</a></li>
                    <li><a class="dropdown-item" href="/admin/activity"><i class="bi bi-clock-history me-2"></i>Lịch sử hoạt động</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('products.index') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i>Xem trang web</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                            </button>
                        </form>
                    </li>
                    @else
                    <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i>Đăng ký</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <form class="w-100" role="search">
                    <div class="search-container">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Tìm kiếm..." id="mobileSearchInput" autocomplete="off">
                    </div>
                </form>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="search-suggestions" id="searchSuggestionsMobile">
                    </div>
            </div>
        </div>
    </div>
</div>


<style>
    /* CSS Variables (Giả định bạn đã định nghĩa ở root) */
    :root {
        --sidebar-width: 250px;
        --navbar-height: 60px;
        --primary-color: #6366f1;
        --border-color: #e5e7eb;
        --text-color: #374151;
        --text-light: #6b7280;
    }

    /* Dark mode variables */
    [data-bs-theme="dark"] {
        --border-color: #334155;
        --text-color: #e2e8f0;
        --text-light: #94a3b8;
    }
    
    /* General Navbar */
    #topNavbar {
        position: fixed;
        top: 0;
        left: var(--sidebar-width);
        right: 0;
        height: var(--navbar-height);
        z-index: 1000;
        transition: left 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }
    
    /* Search Component */
    .navbar-search {
        flex: 1;
        max-width: 450px;
        margin: 0 2rem;
    }
    .search-container {
        position: relative;
    }
    .search-input {
        padding-left: 2.5rem;
        border-radius: 25px;
        background-color: #f8fafc;
        transition: all 0.3s ease;
    }
    .search-input:focus {
        background-color: var(--bs-body-bg);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        border-color: var(--primary-color);
    }
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }
    .search-suggestions {
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        right: 0;
        background-color: var(--bs-body-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: none;
        z-index: 1001;
        max-height: 300px;
        overflow-y: auto;
    }
    #searchSuggestionsMobile { /* Style for mobile search results */
      position: relative;
      top: 0;
      box-shadow: none;
      border: none;
      display: block; /* Always visible inside modal body */
    }

    /* User Profile & Dropdowns */
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }
    .dropdown-menu {
        border-color: var(--border-color);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        padding: 0.5rem 0;
    }
    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.6rem 1.2rem;
        transition: background-color 0.2s ease;
    }
    .dropdown-item i {
      color: var(--text-light);
      transition: color 0.2s ease;
    }
    .dropdown-item:hover i {
      color: var(--primary-color);
    }

    /* Notification & Message Dropdowns */
    .notification-dropdown, .message-dropdown {
        width: 360px;
        max-height: 450px;
        overflow-y: auto;
    }
    .notification-item, .message-item {
        align-items: flex-start;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        text-decoration: none;
        color: inherit;
        white-space: normal;
    }
    .notification-item:last-child, .message-item:last-child {
        border-bottom: none;
    }
    .notification-item.unread, .message-item.unread {
        background-color: rgba(99, 102, 241, 0.05);
    }
    [data-bs-theme="dark"] .notification-item.unread,
    [data-bs-theme="dark"] .message-item.unread {
        background-color: rgba(99, 102, 241, 0.15);
    }
    .notification-icon, .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    .message-avatar {
        object-fit: cover;
    }
    .notification-content, .message-content { flex: 1; }
    .notification-title, .message-name { font-weight: 600; font-size: 0.9rem; }
    .notification-text, .message-text { font-size: 0.85rem; color: var(--text-light); white-space: normal; }
    .notification-time, .message-time { font-size: 0.75rem; color: var(--text-light); margin-top: 0.25rem; }

    .user-dropdown { width: 250px; }
    .user-info { text-align: left; }
    .user-name-header { font-weight: 600; }
    .user-email { font-size: 0.8rem; color: var(--text-light); }
    
    /* Animation for notification badge */
    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        50% { transform: scale(1.1); box-shadow: 0 0 0 5px rgba(220, 53, 69, 0); }
    }
    .badge.bg-danger { animation: pulse 2s infinite; }

    /* Search Modal */
    #searchModal .modal-content {
        background-color: var(--bs-body-bg);
    }
    #searchModal .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
    }
    #searchModal .btn-close {
        margin-left: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        #topNavbar { left: 0; }
        .user-name { display: none !important; }
        .notification-dropdown, .message-dropdown { width: 320px; }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        // --- CORE ELEMENTS ---
        const desktopSearchInput = document.querySelector('.navbar-search .search-input');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const desktopSuggestions = document.getElementById('searchSuggestionsDesktop');
        const mobileSuggestions = document.getElementById('searchSuggestionsMobile');
        const darkModeToggle = document.getElementById('darkModeToggle');
        const fullscreenToggle = document.getElementById('fullscreenToggle');

        // --- INITIALIZATION ---
        initializeTooltips();
        initializeTheme();
        
        // --- EVENT LISTENERS ---

        // Search functionality (for both desktop and mobile)
        [desktopSearchInput, mobileSearchInput].forEach(input => {
            if (input) {
                input.addEventListener('input', (e) => handleSearch(e.target));
                input.addEventListener('focus', (e) => handleSearch(e.target));
            }
        });

        // Hide desktop suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (desktopSearchInput && !desktopSearchInput.contains(e.target) && !desktopSuggestions.contains(e.target)) {
                desktopSuggestions.style.display = 'none';
            }
        });
        
        // Dark Mode Toggle
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', toggleTheme);
        }

        // Fullscreen Toggle
        if (fullscreenToggle) {
            fullscreenToggle.addEventListener('click', toggleFullscreen);
            document.addEventListener('fullscreenchange', updateFullscreenIcon);
        }
        
        // --- FUNCTIONS ---

        /**
         * Initializes Bootstrap Tooltips
         */
        function initializeTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }

        /**
         * Handles search input and triggers suggestion fetching
         * @param {HTMLInputElement} inputElement The input element being typed in
         */
        function handleSearch(inputElement) {
            const query = inputElement.value.trim();
            const suggestionsContainer = (inputElement.id === 'mobileSearchInput') ? mobileSuggestions : desktopSuggestions;
            
            if (query.length < 2) {
                suggestionsContainer.style.display = 'none';
                return;
            }
            fetchSearchSuggestions(query, suggestionsContainer);
        }

        /**
         * Fetches search suggestions from the server
         * @param {string} query The search query
         * @param {HTMLElement} container The element to display suggestions in
         */
        async function fetchSearchSuggestions(query, container) {
            container.style.display = 'block';
            container.innerHTML = '<div class="dropdown-item">Đang tìm...</div>'; // Loading state

            try {
                // --- THAY THẾ BẰNG API THỰC TẾ CỦA BẠN ---
                const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const results = await response.json(); // Giả sử API trả về mảng [{ type, title, url }]

                if (results.length === 0) {
                   container.innerHTML = '<div class="dropdown-item text-muted">Không tìm thấy kết quả.</div>';
                   return;
                }
                
                let html = '';
                results.forEach(item => {
                    html += `
                        <a href="${item.url}" class="dropdown-item">
                            <i class="bi bi-${getIconByType(item.type)} me-3 text-muted"></i>
                            <span>${item.title}</span>
                        </a>`;
                });
                container.innerHTML = html;

            } catch (error) {
                console.error('Search fetch error:', error);
                container.innerHTML = '<div class="dropdown-item text-danger">Lỗi khi tìm kiếm.</div>';
            }
        }
        
        function getIconByType(type) {
            const icons = {
                'product': 'box', 'customer': 'person', 'order': 'cart',
                'category': 'tags', 'page': 'file-text'
            };
            return icons[type] || 'search';
        }

        /**
         * Toggles between light and dark theme
         */
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-bs-theme') === 'dark';
            if (isDark) {
                html.removeAttribute('data-bs-theme');
                localStorage.setItem('theme', 'light');
                darkModeToggle.innerHTML = '<i class="bi bi-moon fs-5"></i>';
            } else {
                html.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                darkModeToggle.innerHTML = '<i class="bi bi-sun fs-5"></i>';
            }
        }
        
        /**
         * Sets the initial theme based on localStorage or system preference
         */
        function initializeTheme() {
            const storedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (storedTheme === 'dark' || (!storedTheme && systemPrefersDark)) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                if (darkModeToggle) darkModeToggle.innerHTML = '<i class="bi bi-sun fs-5"></i>';
            }
        }

        /**
         * Toggles fullscreen mode
         */
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    alert(`Không thể bật chế độ toàn màn hình: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }
        
        /**
         * Updates the fullscreen icon based on the current state
         */
        function updateFullscreenIcon() {
            if(fullscreenToggle) {
                const icon = document.fullscreenElement ? 'bi-fullscreen-exit' : 'bi-fullscreen';
                fullscreenToggle.innerHTML = `<i class="bi ${icon} fs-5"></i>`;
            }
        }

        // Note: The toggleSidebar() function is expected to be defined elsewhere
        // in your application's global scope as it's called via an onclick attribute.
    });

    // Make toggleSidebar globally accessible if it's not already
    // function toggleSidebar() { ... }
</script>