let menuButton = $('.menu');
let nav = $('nav');
let menuClose = $('.menu-close');

menuButton.on('click', function() {
    if (!nav.hasClass('nav-active')) nav.addClass('nav-active');
});

menuClose.on('click', function() {
    if (nav.hasClass('nav-active')) nav.removeClass('nav-active');
});
