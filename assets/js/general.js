jQuery( document ).ready( function ( $ ) {
    var $siteHeader = $('.site-header');
    var $headerPlaceholder = $('.emclient-fixedheader-placeholder');
    var fixmeTop = $siteHeader.offset().top;

    $(window).on('scroll', function () {
        var currentScroll = $(window).scrollTop();
        var isScrolled = currentScroll >= fixmeTop;
        $siteHeader.toggleClass('scroll-with', isScrolled);
        $headerPlaceholder.css('display', isScrolled ? 'block' : 'none');
    });

    $('.site-header .ham-btn').on('click', function () {
        $('.site-header #primary-menu').toggleClass('show-menu');
    });

    // Accessible modal: open/close, focus trap, ESC, return focus
    (() => {
    const focusSelectors = [
        'a[href]', 'area[href]', 'input:not([disabled])', 'select:not([disabled])',
        'textarea:not([disabled])', 'button:not([disabled])', 'iframe', 'object', 'embed',
        '[tabindex]:not([tabindex="-1"])', '[contenteditable="true"]'
    ].join(',');

    let lastTrigger = null;

    const open = (modal) => {
        if (!modal) return;
        lastTrigger = document.activeElement;
        modal.classList.add('is-open');
        document.body.classList.add('modal-lock');
        modal.setAttribute('aria-hidden', 'false');

        // move focus to first focusable
        const first = modal.querySelector(focusSelectors);
        (first || modal).focus();

        // trap focus
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

    const close = (modal) => {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-lock');
        if (modal._onKeydown) modal.removeEventListener('keydown', modal._onKeydown);
        if (lastTrigger && document.contains(lastTrigger)) lastTrigger.focus();
    };

    // Delegation: open
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-modal-open]');
        if (trigger) {
        const target = document.querySelector(trigger.getAttribute('data-modal-open'));
        open(target);
        }
    });

    // close buttons / overlay
    document.addEventListener('click', (e) => {
        const closeBtn = e.target.closest('[data-modal-close]');
        const modal = e.target.closest('.modal');
        if (closeBtn && modal) close(modal);
    });

    // click outside dialog (overlay)
    document.addEventListener('click', (e) => {
        const modal = e.target.closest('.modal');
        if (!modal) return;
        const insideDialog = e.target.closest('.modal__dialog');
        if (!insideDialog) close(modal);
    });
    })();


} );
