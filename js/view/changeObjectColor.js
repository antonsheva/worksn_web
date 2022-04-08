function highlightStars(qt) {
    img_fl = '/service_img/design/star_ok.gif';
    img_clr = '/service_img/design/star_empty.gif';
    for(i=1; i<=5; i++){
        $('[data-star_numb='+i+'] img').attr('src',img_clr);
    }
    for(i=1; i<=qt; i++){
        $('[data-star_numb='+i+'] img').attr('src',img_fl);
    }
}
