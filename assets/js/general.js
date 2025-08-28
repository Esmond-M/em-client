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

// Open menu
$('.site-header .ham-btn').on('click', function () {
  $('.mobile-navigation').addClass('open');
  $('.nav-overlay').addClass('active');
});

// Close menu
$('.mobile-navigation .close-nav-btn, .nav-overlay').on('click', function () {
  $('.mobile-navigation').removeClass('open');
  $('.nav-overlay').removeClass('active');
  $('.mobile-navigation .sub-menu').removeClass('open').hide(); // Close all submenus
});

// Submenu toggle (recursive)
$('.mobile-navigation .submenu-toggle').on('click', function (e) {
  e.preventDefault();
  var $submenu = $(this).closest('li').children('.sub-menu');
  $(this).closest('ul').find('> li > .sub-menu').not($submenu).removeClass('open').hide();
  $submenu.toggleClass('open').show();
  $(this).toggleClass('open');
});

// Submenu back button (recursive)
$('.mobile-navigation .submenu-back-btn').on('click', function (e) {
  e.preventDefault();
  $(this).closest('.sub-menu').removeClass('open').hide();
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
