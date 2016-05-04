$("img.lazy").lazyload();

FastClick.attach(document.body);

$('iframe[src*="youtube.com"]').wrap('<div class="youtubeWrapper" />');

$('.owl-carousel').owlCarousel({
    items: 1,
    nav: false,
    dots: true,
    loop: true,
    lazyLoad: true,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true
});
