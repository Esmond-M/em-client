jQuery(document).ready(function ($) {

    // =========================
    // Header Scroll Behavior
    // =========================
    var $siteHeader = $('.site-header');
    var $headerPlaceholder = $('.emclient-fixedheader-placeholder');
    var fixmeTop = $siteHeader.offset().top;

    $(window).on('scroll', function () {
        var currentScroll = $(window).scrollTop();
        var isScrolled = currentScroll >= fixmeTop;
        $siteHeader.toggleClass('scroll-with', isScrolled);
        $headerPlaceholder.css('display', isScrolled ? 'block' : 'none');
    });

    // =========================
    // Mobile Menu Drawer Toggle
    // =========================

    function isMobileMenu() {
        return window.matchMedia('(max-width: 1199px)').matches;
    }

    // Hamburger button opens/closes side nav
    $('.site-header .ham-btn').on('click', function () {
        $('#site-navigation').toggleClass('open');
        $('.nav-overlay').toggleClass('active');
    });

    // Overlay click closes side nav
    $('.nav-overlay').on('click', function () {
        $('#site-navigation').removeClass('open');
        $(this).removeClass('active');
    });

    // Close button inside nav closes side nav
    $('.close-nav-btn').on('click', function () {
        $('#site-navigation').removeClass('open');
        $('.nav-overlay').removeClass('active');
    });

    // =========================
    // Mobile Submenu Toggle
    // =========================

    $('.site-header #primary-menu').on('click', '.submenu-toggle', function (e) {
        if (isMobileMenu()) {
            e.preventDefault();
            e.stopPropagation();
            var $parentLi = $(this).closest('li');
            var $subMenu = $parentLi.children('ul.sub-menu');
            // Toggle submenu-open on the nearest ul.sub-menu
            $subMenu.toggleClass('submenu-open');
            // Close sibling submenus at the same level
            $parentLi.siblings('li').children('ul.sub-menu.submenu-open').removeClass('submenu-open');
            $(this).focus();
        }
    });

    // =========================
    // Accessible Modal Logic
    // =========================

    (function () {
        // Selectors for focusable elements
        const focusSelectors = [
            'a[href]', 'area[href]', 'input:not([disabled])', 'select:not([disabled])',
            'textarea:not([disabled])', 'button:not([disabled])', 'iframe', 'object', 'embed',
            '[tabindex]:not([tabindex="-1"])', '[contenteditable="true"]'
        ].join(',');

        let lastTrigger = null;

        // Open modal and trap focus
        const open = (modal) => {
            if (!modal) return;
            lastTrigger = document.activeElement;
            modal.classList.add('is-open');
            document.body.classList.add('modal-lock');
            modal.setAttribute('aria-hidden', 'false');

            // Move focus to first focusable element
            const first = modal.querySelector(focusSelectors);
            (first || modal).focus();

            // Trap focus inside modal
            const handleKeydown = (e) => {
                if (e.key === 'Escape') close(modal);
                if (e.key !== 'Tab') return;
                const focusables = [...modal.querySelectorAll(focusSelectors)].filter(el => el.offsetParent !== null || el === document.activeElement);
                if (!focusables.length) return;
                const firstEl = focusables[0];
                const lastEl = focusables[focusables.length - 1];
                if (e.shiftKey && document.activeElement === firstEl) { e.preventDefault(); lastEl.focus(); }
                else if (!e.shiftKey && document.activeElement === lastEl) { e.preventDefault(); firstEl.focus(); }
            };

            modal.dataset.listener = '1';
            modal.addEventListener('keydown', handleKeydown);
            modal._onKeydown = handleKeydown;
        };

        // Close modal and restore focus
        const close = (modal) => {
            if (!modal) return;
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-lock');
            if (modal._onKeydown) modal.removeEventListener('keydown', modal._onKeydown);
            if (lastTrigger && document.contains(lastTrigger)) lastTrigger.focus();
        };

        // Open modal on trigger click
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal-open]');
            if (trigger) {
                const target = document.querySelector(trigger.getAttribute('data-modal-open'));
                open(target);
            }
        });

        // Close modal on close button or overlay click
        document.addEventListener('click', (e) => {
            const closeBtn = e.target.closest('[data-modal-close]');
            const modal = e.target.closest('.modal');
            if (closeBtn && modal) close(modal);
        });

        // Close modal when clicking outside the dialog
        document.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal');
            if (!modal) return;
            const insideDialog = e.target.closest('.modal__dialog');
            if (!insideDialog) close(modal);
        });
    })();

    // =========================
    // Slick Slider Initialization
    // =========================

    $('.demo-slider').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000,
        slidesToShow: 1,
        adaptiveHeight: true
    });
});
