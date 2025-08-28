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


 
});
