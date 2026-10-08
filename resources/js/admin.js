const admin = (() => {
    const sidebar = document.querySelector('[data-sidebar]');
    const backdrop = document.querySelector('[data-sidebar-backdrop]');
    const toggle = document.querySelector('[data-sidebar-toggle]');

    const closeSidebar = () => {
        sidebar?.classList.remove('open');
        backdrop?.classList.remove('open');
        document.body.style.overflow = '';
    };

    const openSidebar = () => {
        sidebar?.classList.add('open');
        backdrop?.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    toggle?.addEventListener('click', () => {
        sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    backdrop?.addEventListener('click', closeSidebar);
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSidebar();
            closeDropdowns();
            closeConfirm();
        }
    });
    window.addEventListener('resize', () => {
        if (window.innerWidth > 1024) closeSidebar();
    });

    const closeDropdowns = (except = null) => {
        document.querySelectorAll('.dropdown-menu.open').forEach((menu) => {
            if (menu !== except) menu.classList.remove('open');
        });
    };

    document.querySelectorAll('[data-dropdown]').forEach((trigger) => {
        const menu = trigger.querySelector('.dropdown-menu');
        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            const willOpen = !menu?.classList.contains('open');
            closeDropdowns(menu);
            menu?.classList.toggle('open', willOpen);
        });
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.dropdown')) closeDropdowns();
        if (!event.target.closest('.header-search')) closeSearch();
    });

    const searchInput = document.querySelector('[data-search-input]');
    const searchResults = document.querySelector('[data-search-results]');
    const searchIndex = (window.ADMIN_SEARCH_INDEX || []).map((item) => ({ ...item, hay: item.label.toLowerCase() }));

    const closeSearch = () => searchResults?.classList.remove('open');

    const renderSearch = (query) => {
        if (!searchResults) return;
        const q = query.trim().toLowerCase();

        if (!q) {
            closeSearch();
            return;
        }

        const matches = searchIndex.filter((item) => item.hay.includes(q)).slice(0, 7);

        searchResults.innerHTML = matches.length
            ? matches.map((item) => `<a href="${item.href}">${item.icon || ''}<span>${item.label}</span></a>`).join('')
            : '<p class="empty-note">No matching section found.</p>';

        searchResults.classList.add('open');
    };

    searchInput?.addEventListener('input', (event) => renderSearch(event.target.value));
    searchInput?.addEventListener('focus', (event) => renderSearch(event.target.value));
    searchInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            const first = searchResults?.querySelector('a');
            if (first) {
                event.preventDefault();
                window.location.href = first.href;
            }
        }
    });

    document.addEventListener('keydown', (event) => {
        if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
            event.preventDefault();
            searchInput?.focus();
        }
    });

    document.querySelectorAll('[data-filter-form]').forEach((form) => {
        const submit = () => form.submit();
        form.querySelectorAll('select').forEach((select) => select.addEventListener('change', submit));
        let timer;
        form.querySelectorAll('input[type="search"], input[name="q"]').forEach((input) => {
            input.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(submit, 450);
            });
        });
    });

    document.querySelectorAll('form[data-loading]').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('[type="submit"]');
            if (button && !button.classList.contains('is-loading')) {
                button.classList.add('is-loading');
                button.setAttribute('aria-busy', 'true');
            }
        });
    });

    const confirmBox = document.querySelector('[data-confirm-box]');
    const confirmTitle = confirmBox?.querySelector('[data-confirm-title]');
    const confirmText = confirmBox?.querySelector('[data-confirm-text]');
    const confirmAccept = confirmBox?.querySelector('[data-confirm-accept]');
    const confirmCancel = confirmBox?.querySelector('[data-confirm-cancel]');
    let pendingForm = null;

    const closeConfirm = () => {
        confirmBox?.classList.remove('open');
        document.body.style.overflow = '';
        pendingForm = null;
    };

    document.addEventListener('submit', (event) => {
        const trigger = event.target.closest('[data-confirm]');
        if (!trigger || !confirmBox) return;

        event.preventDefault();
        pendingForm = trigger;
        confirmTitle.textContent = trigger.dataset.confirmTitle || 'Are you sure?';
        confirmText.textContent = trigger.dataset.confirm || 'This action cannot be undone.';
        confirmBox.classList.add('open');
        document.body.style.overflow = 'hidden';
        confirmAccept?.focus();
    });

    confirmAccept?.addEventListener('click', () => {
        if (!pendingForm) return;
        confirmAccept.classList.add('is-loading');
        pendingForm.submit();
    });

    confirmCancel?.addEventListener('click', closeConfirm);
    confirmBox?.addEventListener('click', (event) => {
        if (event.target === confirmBox) closeConfirm();
    });

    const toastStack = document.querySelector('[data-toasts]');

    const showToast = (tone, title, message) => {
        if (!toastStack) return;

        const toast = document.createElement('div');
        toast.className = `toast${tone ? ` is-${tone}` : ''}`;
        toast.setAttribute('role', 'status');

        const icon = tone === 'error'
            ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

        toast.innerHTML = `
            <span class="toast-icon">${icon}</span>
            <div class="toast-body"><strong>${title}</strong>${message ? `<p>${message}</p>` : ''}</div>
            <button class="toast-close" type="button" aria-label="Dismiss">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>`;

        const dismiss = () => {
            toast.classList.add('is-leaving');
            setTimeout(() => toast.remove(), 260);
        };

        toast.querySelector('.toast-close').addEventListener('click', dismiss);
        toastStack.appendChild(toast);
        setTimeout(dismiss, 5000);
    };

    window.adminToast = showToast;

    toastStack?.querySelectorAll('.toast').forEach((toast) => {
        const dismiss = () => {
            toast.classList.add('is-leaving');
            setTimeout(() => toast.remove(), 260);
        };
        toast.querySelector('.toast-close')?.addEventListener('click', dismiss);
        setTimeout(dismiss, 5000);
    });

    document.querySelectorAll('[data-image-input]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            const preview = document.querySelector(input.dataset.imageInput);
            if (!preview || !file) return;
            preview.src = URL.createObjectURL(file);
        });
    });

    document.querySelectorAll('[data-chart-bar]').forEach((bar) => {
        requestAnimationFrame(() => {
            bar.style.height = `${bar.dataset.height}%`;
        });
    });

    document.querySelectorAll('[data-hbar]').forEach((fill) => {
        requestAnimationFrame(() => {
            fill.style.width = `${fill.dataset.hbar}%`;
        });
    });

    return { showToast, closeSidebar, closeDropdowns };
})();
