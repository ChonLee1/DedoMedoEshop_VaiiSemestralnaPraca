// mobilne menu - burger toggle pre responzivnu navigaciu
document.addEventListener('DOMContentLoaded', () => {

    try {
        // elementy z partials/nav.blade.php
        const nav = document.querySelector('.nav');
        const toggle = document.querySelector('.nav__toggle');  // burger button
        const menu = document.getElementById('nav-menu');       // ul s linkami

        if (!nav || !toggle || !menu) {
            return;
        }

        // aria atributy pre pristupnost (screen readers)
        toggle.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');

        const closeMenu = () => {
            toggle.setAttribute('aria-expanded', 'false');
            menu.classList.remove('open');  // .open trieda riadi viditelnost v CSS
            menu.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';  // povol scroll
        };

        const openMenu = () => {
            toggle.setAttribute('aria-expanded', 'true');
            menu.classList.add('open');
            menu.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';  // zamkni scroll ked je menu otvorene
        };

        // toggle klik - prepina medzi otvorenim/zatvorenim
        toggle.addEventListener('click', (e) => {
            if (toggle.tagName.toLowerCase() === 'summary') e.preventDefault();
            e.stopPropagation();
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            isOpen ? closeMenu() : openMenu();
        });

        // klik mimo menu ho zavrie
        document.addEventListener('click', (e) => {
            if (!menu.classList.contains('open')) return;
            if (!menu.contains(e.target) && !toggle.contains(e.target)) closeMenu();
        });

        // ESC klavesa zavrie menu
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && menu.classList.contains('open')) {
                e.preventDefault();
                closeMenu();
            }
        });

        // ak sa okno zvacsci na desktop, zatvor mobilne menu
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 640 && menu.classList.contains('open')) {
                closeMenu();
            }
        });

    } catch (err) {
        console.error('nav.js error:', err);
    }
});


