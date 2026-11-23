document.addEventListener('DOMContentLoaded', function () {
    var config = document.getElementById('backend-app-config');
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    window.uploadUrl = config ? config.dataset.uploadUrl || '' : '';

    function showToast(icon, title, text) {
        if (typeof Swal === 'undefined') {
            return;
        }

        Swal.fire({
            toast: true,
            position: 'bottom-start',
            icon: icon,
            title: title,
            text: text,
            timer: 2200,
            timerProgressBar: true,
            showConfirmButton: false,
            showCloseButton: true
        });
    }

    window.showBackendToast = showToast;

    if (config && config.dataset.successMessage) {
        showToast('success', 'Thanh cong', config.dataset.successMessage);
    }

    if (config && config.dataset.errorMessage) {
        showToast('error', 'Co loi xay ra', config.dataset.errorMessage);
    }

    if (config && config.dataset.validationMessage) {
        showToast('warning', 'Vui long kiem tra du lieu', config.dataset.validationMessage);
    }

    document.querySelectorAll('[data-confirm-delete]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var message = form.getAttribute('data-confirm-message') || 'Ban co chac muon xoa muc nay?';

            Swal.fire({
                icon: 'warning',
                title: 'Xac nhan xoa',
                text: message,
                showCancelButton: true,
                confirmButtonText: 'Xoa',
                cancelButtonText: 'Huy',
                confirmButtonColor: '#f06548',
                cancelButtonColor: '#405189'
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('[data-toggle-status]').forEach(function (button) {
        button.addEventListener('click', function () {
            var url = button.getAttribute('data-url');
            var label = button.parentElement ? button.parentElement.querySelector('[data-status-label]') : null;
            var blockedReason = button.getAttribute('data-blocked-reason');

            if (!url) {
                return;
            }

            if (blockedReason && button.classList.contains('is-inactive')) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Không thể bật tài khoản',
                        text: blockedReason,
                        confirmButtonText: 'Đã hiểu',
                        confirmButtonColor: '#405189'
                    });
                } else {
                    alert(blockedReason);
                }
                return;
            }

            button.disabled = true;

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) {
                            var err = new Error(data.message || 'Không thể cập nhật trạng thái.');
                            err.blocked = data.blocked || false;
                            throw err;
                        }
                        return data;
                    });
                })
                .then(function (data) {
                    var isActive = typeof data.is_active !== 'undefined' ? data.is_active : (typeof data.is_special !== 'undefined' ? data.is_special : data.is_featured);
                    button.classList.toggle('is-active', isActive);
                    button.classList.toggle('is-inactive', !isActive);
                    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');

                    if (label) {
                        label.textContent = data.label;
                        label.classList.toggle('text-success', isActive);
                        label.classList.toggle('text-danger', !isActive);
                    }

                    showToast('success', 'Đã cập nhật', data.message);
                })
                .catch(function (err) {
                    if (err && err.blocked && typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Không thể bật tài khoản',
                            text: err.message,
                            confirmButtonText: 'Đã hiểu',
                            confirmButtonColor: '#405189'
                        });
                    } else {
                        showToast('error', 'Không cập nhật được', (err && err.message) ? err.message : 'Vui lòng thử lại.');
                    }
                })
                .finally(function () {
                    button.disabled = false;
                });
        });
    });

    document.querySelectorAll('[data-update-sort-order]').forEach(function (input) {
        var submitSortOrder = function () {
            var url = input.getAttribute('data-url');
            var currentValue = input.value.trim();
            var initialValue = input.getAttribute('data-initial-value');

            if (!url || currentValue === '' || currentValue === initialValue) {
                if (currentValue === '') {
                    input.value = initialValue || 0;
                }

                return;
            }

            input.disabled = true;

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json'
                },
                body: JSON.stringify({
                    sort_order: Number(currentValue)
                })
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Update sort order failed');
                    }

                    return response.json();
                })
                .then(function (data) {
                    input.value = data.sort_order;
                    input.setAttribute('data-initial-value', data.sort_order);
                    showToast('success', 'Da cap nhat', data.message);
                })
                .catch(function () {
                    input.value = initialValue || 0;
                    showToast('error', 'Khong cap nhat duoc', 'Vui long thu lai.');
                })
                .finally(function () {
                    input.disabled = false;
                });
        };

        input.addEventListener('blur', submitSortOrder);
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                input.blur();
            }
        });
    });

    if (typeof initEditor === 'function') {
        initEditor();
    }

    // Flyout Submenu Panel for Admin Sidebar
    (function initAdminFlyoutSubmenu() {
        var panel = document.getElementById('admin-flyout-submenu-panel');
        var sidebar = document.querySelector('.app-menu.navbar-menu');
        var items = document.querySelectorAll('.nav-item.has-flyout-submenu');

        if (!panel || !sidebar || !items.length) {
            return;
        }

        var hideTimer = null;
        var activeItem = null;

        function clearHideTimer() {
            if (hideTimer) {
                clearTimeout(hideTimer);
                hideTimer = null;
            }
        }

        function scheduleHide() {
            clearHideTimer();
            hideTimer = setTimeout(function () {
                hidePanel();
            }, 180);
        }

        function hidePanel() {
            panel.classList.remove('is-visible');
            panel.setAttribute('aria-hidden', 'true');
            if (activeItem) {
                activeItem.classList.remove('is-flyout-open');
                activeItem = null;
            }
        }

        function positionPanel(item) {
            var sidebarRect = sidebar.getBoundingClientRect();
            var itemRect = item.getBoundingClientRect();

            var leftPos = Math.max(sidebarRect.right + 4, 70);
            panel.style.left = leftPos + 'px';

            var topPos = itemRect.top;
            var panelHeight = panel.offsetHeight || 260;
            var viewportHeight = window.innerHeight;

            if (topPos + panelHeight > viewportHeight - 16) {
                topPos = Math.max(76, viewportHeight - panelHeight - 16);
            }
            if (topPos < 70) {
                topPos = 70;
            }

            panel.style.top = topPos + 'px';
        }

        function showPanelForItem(item) {
            clearHideTimer();

            var template = item.querySelector('.flyout-submenu-template');
            if (!template) {
                hidePanel();
                return;
            }

            if (activeItem && activeItem !== item) {
                activeItem.classList.remove('is-flyout-open');
            }

            activeItem = item;
            activeItem.classList.add('is-flyout-open');

            panel.innerHTML = template.innerHTML;
            panel.classList.add('is-visible');
            panel.setAttribute('aria-hidden', 'false');

            positionPanel(item);
        }

        items.forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                showPanelForItem(item);
            });

            item.addEventListener('mouseleave', function () {
                scheduleHide();
            });
        });

        panel.addEventListener('mouseenter', function () {
            clearHideTimer();
        });

        panel.addEventListener('mouseleave', function () {
            scheduleHide();
        });

        window.addEventListener('scroll', function () {
            if (activeItem && panel.classList.contains('is-visible')) {
                positionPanel(activeItem);
            }
        }, true);

        window.addEventListener('resize', function () {
            if (activeItem && panel.classList.contains('is-visible')) {
                positionPanel(activeItem);
            }
        });
    })();
});
