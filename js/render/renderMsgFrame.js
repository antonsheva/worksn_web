function renderMsgStatus(status) {
    switch (status){
        case 1:
            $('.messagesFrame [data-status ='+0+']').attr('src','/service_img/design/birdie_2.bmp');
            $('.messagesFrame [data-status ='+0+']').attr('data-status',1);
            break;
        case 2:
            $('.messagesFrame [data-status ='+0+']').attr('src','/service_img/design/birdie_3.bmp');
            $('.messagesFrame [data-status ='+0+']').attr('data-status',2);
            $('.messagesFrame [data-status ='+1+']').attr('src','/service_img/design/birdie_3.bmp');
            $('.messagesFrame [data-status ='+1+']').attr('data-status',2);
    }
}
