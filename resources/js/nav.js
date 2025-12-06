// resources/js/nav.js
// Import this from resources/js/app.js: import './nav.js'

const initNav = () => {
    const nav = document.querySelector('.nav');
    const toggle = document.querySelector('.nav__toggle');
    const menu = document.getElementById('nav-menu');
    const closeBtn = menu ? menu.querySelector('.nav__close') : null;
    const focusableSelector = 'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])';
    let lastFocused = null;

    if (!nav || !toggle || !menu) return;

    // set CSS var for nav height so overlay anchors correctly
    const updateNavTop = () => {
        const height = nav.offsetHeight || 64;
        nav.style.setProperty('--nav-top', height + 'px');
        // also set on menu in case it's used elsewhere
        menu.style.setProperty('--nav-top', height + 'px');
    };

    // update responsive state: hide close button and clear overlay inline styles on desktop
    const updateResponsiveState = () => {
        const isDesktop = window.innerWidth >= 640;
        if (closeBtn) {
            if (isDesktop) {
                // ensure it's hidden
                closeBtn.style.display = 'none';
            } else {
                // allow CSS to handle display when mobile
                closeBtn.style.display = '';
            }
        }

        if (isDesktop) {
            // ensure menu overlay is closed and any inline overlay styles are cleared
            menu.classList.remove('open');
            menu.setAttribute('aria-hidden', 'false');
            menu.style.transform = '';
            menu.style.opacity = '';
            menu.style.height = '';
            menu.style.background = '';
            menu.style.boxShadow = '';
            document.body.style.overflow = '';
            toggle.setAttribute('aria-expanded', 'false');
        } else {
            // clear any desktop-forcing inline cleanups so CSS can control overlay
            menu.style.transform = '';
            menu.style.opacity = '';
            menu.style.height = '';
            menu.style.background = '';
            menu.style.boxShadow = '';
        }
    };

    updateNavTop();
    updateResponsiveState();
    window.addEventListener('resize', () => { updateNavTop(); updateResponsiveState(); });

    const setOpen = (open) => {
        const isOpen = !!open;
        toggle.setAttribute('aria-expanded', String(isOpen));
        menu.classList.toggle('open', isOpen);
        menu.setAttribute('aria-hidden', String(!isOpen));

        if (isOpen) {
            lastFocused = document.activeElement;
            document.body.style.overflow = 'hidden'; // lock scroll
            // focus close button if present, else first focusable
            if (closeBtn) {
                closeBtn.focus();
            } else {
                const focusables = Array.from(menu.querySelectorAll(focusableSelector)).filter(el => el.offsetParent !== null);
                if (focusables.length) focusables[0].focus();
            }
            document.addEventListener('keydown', trapHandler);
        } else {
            document.body.style.overflow = '';
            document.removeEventListener('keydown', trapHandler);
            if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
        }
    };

    // ensure menu is closed on init for larger screens
    if (window.innerWidth >= 640) {
        setOpen(false);
    }

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => { e.stopPropagation(); setOpen(false); });
    }

    // close on outside click
    document.addEventListener('click', (e) => {
        if (!menu.classList.contains('open')) return;
        if (!menu.contains(e.target) && !toggle.contains(e.target)) setOpen(false);
    });

    // close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            e.preventDefault();
            setOpen(false);
        }
    });

    // close when resizing to a larger viewport (prevents mobile overlay staying open)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 640 && menu.classList.contains('open')) {
            setOpen(false);
            updateResponsiveState();
        }
    });

    // Focus trap handler
    function trapHandler(e) {
        if (e.key !== 'Tab') return;
        const focusables = Array.from(menu.querySelectorAll(focusableSelector)).filter(el => el.offsetParent !== null);
        if (!focusables.length) return;
        const first = focusables[0];
        const last = focusables[focusables.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === first) {
                e.preventDefault();
                last.focus();
            }
        } else {
            if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }
};

// initialize when DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNav);
} else {
    initNav();
}
