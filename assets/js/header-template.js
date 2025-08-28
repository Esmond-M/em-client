jQuery(document).ready(function ($) {
  var $header = $('#mobile-site-navigation');

  // Open menu
  $header.find('.ham-btn').on('click', function () {
    $header.find('.main-navigation').addClass('open');
    $header.find('.nav-overlay').addClass('active');
  });

  // Close menu
  $header.find('.close-nav-btn, .nav-overlay').on('click', function () {
    $header.find('.main-navigation').removeClass('open');
    $header.find('.nav-overlay').removeClass('active');
    $header.find('.sub-menu').removeClass('open').hide(); // Close all submenus
  });

  // Submenu toggle (recursive)
  $header.find('.submenu-toggle').on('click', function (e) {
    e.preventDefault();
    var $submenu = $(this).closest('li').children('.sub-menu');
    // Only close sibling submenus at this level
    $(this).closest('ul').find('> li > .sub-menu').not($submenu).removeClass('open').hide();
    $submenu.toggleClass('open').show();
    $(this).toggleClass('open');
  });

  // Submenu back button (recursive)
  $header.find('.submenu-back-btn').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.sub-menu').removeClass('open').hide();
  });
});