//sticky top navigation
hdr = $('header').height();
$(window).scroll(function(e) {
    e.preventDefault();
    if( $(this).scrollTop() > 100 ) {
        $('header>.herobar').hide();
        $('.cbp-hrmenu > ul > li > a').addClass('sticky-nav');
        $('header.container-fluid').addClass('sticky-header').css('z-index','1000');
    } else {
        $('header>.herobar').show();
        $('.cbp-hrmenu > ul > li > a').removeClass('sticky-nav');
        $('header.container-fluid').removeClass('sticky-header').removeProp('style');
    }
});