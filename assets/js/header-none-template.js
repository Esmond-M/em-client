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


    // Open submenu as sidenav on mobile
$('#site-navigation .submenu-toggle').on('click', function(e) {
    if (isMobileMenu()) {
        e.preventDefault();
        e.stopPropagation();
                // Select all top-level li
        var $toplevelLi = $('#primary-menu > li.toplevel-item');
        var $parentLi = $(this).closest('li');
        var $subMenu = $parentLi.children('ul.sub-menu');
        $subMenu.addClass('submenu-open');
        $toplevelLi.addClass('submenu-active');
    }
});

    // Back button closes submenu
$('#site-navigation .submenu-back-btn').on('click', function(e) {
    e.preventDefault();
    var $subMenu = $(this).closest('ul.sub-menu');
 var $toplevelLi = $('#primary-menu > li.toplevel-item');
    $subMenu.removeClass('submenu-open');
    $toplevelLi.removeClass('submenu-active');
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

 
});
