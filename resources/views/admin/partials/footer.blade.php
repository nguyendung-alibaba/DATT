<!-- Footer -->
<footer class="admin-footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="footer-info">
                    <span class="text-muted">
                        © {{ date('Y') }} <strong>Fona Panel</strong>.
                        Phiên bản 2.0.1 - Được phát triển
                        <i class="bi bi-heart-fill text-danger"></i> bởi <strong>Ndungz development</strong>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- System Status -->
        <div class="row mt-2">
            <div class="col-12">
                <div class="system-status">
                    <div class="status-item">
                        <span class="status-label">Trạng thái hệ thống:</span>
                        <span class="status-indicator status-online">
                            <i class="bi bi-circle-fill"></i> Online
                        </span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Phiên làm việc:</span>
                        <span class="status-value" id="sessionTime">00:00:00</span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Lần đăng nhập cuối:</span>
                        <span class="status-value">
                            @auth
                                {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'Chưa xác định' }}
                            @else
                                Chưa đăng nhập
                            @endauth
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
    <!-- Toasts will be dynamically inserted here -->
</div>

<style>
/* Footer Styles */
.admin-footer {
    background: white;
    border-top: 1px solid var(--border-color);
    padding: 1.5rem 0;
    margin-top: auto;
    margin-left: var(--sidebar-width);
    transition: margin-left 0.3s ease;
    font-size: 0.875rem;
}

.footer-info {
    color: var(--text-light);
}

.footer-links {
    display: flex;
    gap: 1.5rem;
    justify-content: flex-end;
    align-items: center;
}

.footer-link {
    color: var(--text-light);
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 0.875rem;
}

.footer-link:hover {
    color: var(--primary-color);
}

/* System Status */
.system-status {
    display: flex;
    gap: 2rem;
    align-items: center;
    font-size: 0.8rem;
    color: var(--text-light);
    border-top: 1px solid #f1f5f9;
    padding-top: 0.75rem;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-label {
    font-weight: 500;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-weight: 600;
}

.status-online {
    color: #10b981;
}

.status-offline {
    color: #ef4444;
}

.status-maintenance {
    color: #f59e0b;
}

.status-value {
    font-weight: 500;
    color: var(--text-dark);
}

/* Back to Top */
.back-to-top {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.back-to-top:hover {
    background: #5856eb;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

/* Toast Styles */
.toast {
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.toast-header {
    background: var(--primary-color);
    color: white;
    border-bottom: none;
}

.toast-success .toast-header {
    background: #10b981;
}

.toast-error .toast-header {
    background: #ef4444;
}

.toast-warning .toast-header {
    background: #f59e0b;
}

.toast-info .toast-header {
    background: #3b82f6;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-footer {
        margin-left: 0;
        padding: 1rem 0;
    }
    
    .footer-links {
        justify-content: center;
        margin-top: 1rem;
        gap: 1rem;
    }
    
    .system-status {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .back-to-top {
        bottom: 1rem;
        right: 1rem;
        width: 45px;
        height: 45px;
    }
}

/* Collapsed sidebar */
.main-content.expanded .admin-footer {
    margin-left: 70px;
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .admin-footer {
        background: #1e293b;
        border-color: #334155;
        color: #e2e8f0;
    }
    
    .footer-info,
    .footer-link,
    .system-status {
        color: #94a3b8;
    }
    
    .footer-link:hover {
        color: #a78bfa;
    }
    
    .status-value {
        color: #e2e8f0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Session Timer
    let sessionStartTime = new Date();
    const sessionTimer = document.getElementById('sessionTime');
    
    function updateSessionTime() {
        const now = new Date();
        const diff = now - sessionStartTime;
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        sessionTimer.textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    if (sessionTimer) {
        setInterval(updateSessionTime, 1000);
    }
    
    // Back to Top Button
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // System Status Check (Mock)
    checkSystemStatus();
    setInterval(checkSystemStatus, 30000); // Check every 30 seconds
});

function checkSystemStatus() {
    // Mock system status check
    const statusIndicator = document.querySelector('.status-indicator');
    
    // Simulate API call
    fetch('/admin/api/system-status')
        .then(response => response.json())
        .then(data => {
            if (statusIndicator) {
                statusIndicator.className = `status-indicator status-${data.status}`;
                statusIndicator.innerHTML = `<i class="bi bi-circle-fill"></i> ${data.message}`;
            }
        })
        .catch(() => {
            // Default to online if check fails
            if (statusIndicator) {
                statusIndicator.className = 'status-indicator status-online';
                statusIndicator.innerHTML = '<i class="bi bi-circle-fill"></i> Online';
            }
        });
}

// Toast Functions
function showToast(message, type = 'success', title = '') {
    const toastContainer = document.getElementById('toastContainer');
    const toastId = 'toast-' + Date.now();
    
    const toastHTML = `
        <div class="toast toast-${type}" role="alert" aria-live="assertive" aria-atomic="true" id="${toastId}">
            <div class="toast-header">
                <i class="bi bi-${getToastIcon(type)} me-2"></i>
                <strong class="me-auto">${title || getToastTitle(type)}</strong>
                <small class="text-light">Vừa xong</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 5000
    });
    
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}

function getToastIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'x-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

function getToastTitle(type) {
    const titles = {
        'success': 'Thành công',
        'error': 'Lỗi',
        'warning': 'Cảnh báo',
        'info': 'Thông tin'
    };
    return titles[type] || 'Thông báo';
}

// Global error handler
window.addEventListener('error', function(e) {
    showToast('Đã xảy ra lỗi không mong muốn. Vui lòng thử lại.', 'error');
});

// Form validation feedback
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.classList.contains('was-validated') && !form.checkValidity()) {
        showToast('Vui lòng kiểm tra lại thông tin đã nhập.', 'warning');
    }
});
</script>