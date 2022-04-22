function renderMsgStatus(status) {
    switch (status){
        case 1:
            $('.messagesFrame [data-status ='+MSG_STATUS_NOT_DELIVER+']').attr('src',URL_IMG_BIRDIE_2);
            $('.messagesFrame [data-status ='+MSG_STATUS_NOT_DELIVER+']').attr('data-status',MSG_STATUS_DELIVER);
            break;
        case 2:
            $('.messagesFrame [data-status ='+MSG_STATUS_NOT_DELIVER+']').attr('src',URL_IMG_BIRDIE_3);
            $('.messagesFrame [data-status ='+MSG_STATUS_NOT_DELIVER+']').attr('data-status',MSG_STATUS_READ);
            $('.messagesFrame [data-status ='+MSG_STATUS_DELIVER+']').attr('src',URL_IMG_BIRDIE_3);
            $('.messagesFrame [data-status ='+MSG_STATUS_DELIVER+']').attr('data-status',MSG_STATUS_READ);
    }
}
