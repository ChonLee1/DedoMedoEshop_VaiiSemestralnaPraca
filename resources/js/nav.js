document.addEventListener('DOMContentLoaded', () => {
    console.log('nav.js: DOMContentLoaded');

    try {
        const nav = document.querySelector('.nav');
        const toggle = document.querySelector('.nav__toggle');
        const menu = document.getElementById('nav-menu');

        console.log('nav.js: nodes ->', { navExists: !!nav, toggleExists: !!toggle, menuExists: !!menu });

        if (!nav || !toggle || !menu) {
            console.error('nav.js: Missing required element(s). Ensure markup includes: .nav, .nav__toggle, #nav-menu and that nav.js is imported in resources/js/app.js and assets rebuilt.');
            return;
        }

        toggle.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');

        const closeMenu = () => {
            toggle.setAttribute('aria-expanded', 'false');
            menu.classList.remove('open');
            menu.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            console.log('nav.js: menu closed');
        };

        const openMenu = () => {
            toggle.setAttribute('aria-expanded', 'true');
            menu.classList.add('open');
            menu.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            console.log('nav.js: menu opened');
        };

        toggle.addEventListener('click', (e) => {
            if (toggle.tagName.toLowerCase() === 'summary') e.preventDefault();
            e.stopPropagation();
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            isOpen ? closeMenu() : openMenu();
        });

        document.addEventListener('click', (e) => {
            if (!menu.classList.contains('open')) return;
            if (!menu.contains(e.target) && !toggle.contains(e.target)) closeMenu();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && menu.classList.contains('open')) {
                e.preventDefault();
                closeMenu();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 640 && menu.classList.contains('open')) {
                closeMenu();
            }
        });

        console.log('nav.js: initialized successfully');
    } catch (err) {
        console.error('nav.js: unexpected error', err);
    }
});


