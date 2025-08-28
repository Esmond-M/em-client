jQuery(document).ready(function ($) {
  // Open menu
  $('.ham-btn').on('click', function () {
    $('.main-navigation').addClass('open');
    $('.nav-overlay').addClass('active');
  });

  // Close menu
  $('.close-nav-btn, .nav-overlay').on('click', function () {
    $('.main-navigation').removeClass('open');
    $('.nav-overlay').removeClass('active');
    $('.sub-menu').removeClass('open').hide(); // Close all submenus
  });

  // Submenu toggle (recursive)
  $('.submenu-toggle').on('click', function (e) {
    e.preventDefault();
    var $submenu = $(this).closest('li').children('.sub-menu');
    // Only close sibling submenus at this level
    $(this).closest('ul').find('> li > .sub-menu').not($submenu).removeClass('open').hide();
    $submenu.toggleClass('open').show();
    $(this).toggleClass('open');
  });

  // Submenu back button (recursive)
  $('.submenu-back-btn').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.sub-menu').removeClass('open').hide();
  });
});