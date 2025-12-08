// resources/js/nav.js
// Zapoj v resources/js/app.js cez: import './nav.js'

/**
 * Inicializácia responzívnej navigácie (burger + overlay)
 * - nastaví CSS premennú --nav-top podľa reálnej výšky headeru
 * - prepína otvorenie/zatvorenie menu s ARIA atribútmi
 * - uzamkne scroll tela pri otvorenom menu
 * - rieši „focus trap“ pre prístupnosť (Tab sa cyklí v menu)
 * - zatvára na klik mimo, Escape a pri zväčšení okna (≥ 640 px)
 */
const initNav = () => {
    // Základné uzly: hlavička, burger, overlay menu a tlačidlo „Zavrieť“
    const nav = document.querySelector('.nav');
    const toggle = document.querySelector('.nav__toggle');
    const menu = document.getElementById('nav-menu');
    const closeBtn = menu ? menu.querySelector('.nav__close') : null;

    // Selektor focusovateľných prvkov (pre „focus trap“)
    const focusableSelector = 'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])';
    let lastFocused = null; // kam vrátime focus po zavretí

    // Ak niečo chýba, skript potichu skončí
    if (!nav || !toggle || !menu) return;

    // --nav-top: výška headeru pre korektné ukotvenie overlay menu pod hlavičku
    const updateNavTop = () => {
        const height = nav.offsetHeight || 64;
        nav.style.setProperty('--nav-top', height + 'px');
        // pre istotu aj na menu (ak by štýly čítali z .nav__menu)
        menu.style.setProperty('--nav-top', height + 'px');
    };

    /**
     * Reset/údržba stavu pri breakpointoch:
     * - na desktope skryť closeBtn, vynútiť „inline“ stav a povoliť scroll
     * - na mobile ponechať riadenie na CSS (inline štýly vyčistiť)
     */
    const updateResponsiveState = () => {
        const isDesktop = window.innerWidth >= 640;

        if (closeBtn) {
            // Na desktope je X zbytočné (menu nie je overlay)
            closeBtn.style.display = isDesktop ? 'none' : '';
        }

        if (isDesktop) {
            // Zatvoriť overlay, ARIA a inline štýly uviesť do neutrálneho stavu
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
            // Nechať kontrolu na CSS – inline zásahy z desktopu vyčistiť
            menu.style.transform = '';
            menu.style.opacity = '';
            menu.style.height = '';
            menu.style.background = '';
            menu.style.boxShadow = '';
        }
    };

    // Po načítaní: nastaviť výšku headeru a prispôsobiť stav
    updateNavTop();
    updateResponsiveState();

    // Pri zmene rozmerov: udržať správnu výšku a režim (mobile/desktop)
    window.addEventListener('resize', () => { updateNavTop(); updateResponsiveState(); });

    /**
     * Otvorí/Zavrie overlay menu.
     * - nastaví ARIA (aria-expanded/aria-hidden)
     * - uzamkne/povolí scroll tela
     * - spravuje focus (focus trap + návrat na posledný element)
     */
    const setOpen = (open) => {
        const isOpen = !!open;
        toggle.setAttribute('aria-expanded', String(isOpen));
        menu.classList.toggle('open', isOpen);
        menu.setAttribute('aria-hidden', String(!isOpen));

        if (isOpen) {
            // Zapamätaj si kde bol focus a zamkni scroll
            lastFocused = document.activeElement;
            document.body.style.overflow = 'hidden';

            // Presun fokusu na closeBtn alebo prvý focusovateľný prvok v menu
            if (closeBtn) {
                closeBtn.focus();
            } else {
                const focusables = Array.from(menu.querySelectorAll(focusableSelector))
                    .filter(el => el.offsetParent !== null);
                if (focusables.length) focusables[0].focus();
            }

            // Aktivuj focus trap (Tab sa cyklí v rámci menu)
            document.addEventListener('keydown', trapHandler);
        } else {
            // Uvoľni scroll, vypni trap a vráť focus späť
            document.body.style.overflow = '';
            document.removeEventListener('keydown', trapHandler);
            if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
        }
    };

    // Bezpečnosť pri načítaní: ak štartujeme na desktope, menu nech je zatvorené
    if (window.innerWidth >= 640) {
        setOpen(false);
    }

    // Klik na burger: toggle otvorenia
    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    // Klik na X: zatvoriť overlay
    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => { e.stopPropagation(); setOpen(false); });
    }

    // Klik mimo overlay: zatvoriť (len ak je otvorený)
    document.addEventListener('click', (e) => {
        if (!menu.classList.contains('open')) return;
        if (!menu.contains(e.target) && !toggle.contains(e.target)) setOpen(false);
    });

    // Kláves Escape: zatvoriť
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            e.preventDefault();
            setOpen(false);
        }
    });

    // Pri prechode na desktop (≥ 640 px): zavri overlay a zresetuj stav
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 640 && menu.classList.contains('open')) {
            setOpen(false);
            updateResponsiveState();
        }
    });

    /**
     * Focus trap – udrží Tab/Shift+Tab v rámci overlay menu,
     * aby používateľ „neutiekol“ fokusom mimo otvorené mobilné menu.
     */
    function trapHandler(e) {
        if (e.key !== 'Tab') return;
        const focusables = Array.from(menu.querySelectorAll(focusableSelector))
            .filter(el => el.offsetParent !== null);
        if (!focusables.length) return;

        const first = focusables[0];
        const last = focusables[focusables.length - 1];

        if (e.shiftKey) {
            // Shift+Tab na prvom -> skoč na posledný
            if (document.activeElement === first) {
                e.preventDefault();
                last.focus();
            }
        } else {
            // Tab na poslednom -> skoč na prvý
            if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }
};

// Spusti po načítaní DOM (bez ohľadu na to, kedy sa skript vloží)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNav);
} else {
    initNav();
}
