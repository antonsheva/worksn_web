var msgVars = {
    discusId   : null,
    senderId   : null,
    cinsumerId : null,
    speakerId  : null,
    messages   : []
}
var G_tmp_msg = {
    id                  : null,
    sender_id           : null,
    consumer_id         : null,
    content             : null,
    img                 : null,
    img_icon            : null,
    view                : null,
    create_date         : null,
    ads_id              : null,
    discus_id           : null,
    create_id           : null,
    reply_msg_id        : null,
    reply_content       : null,
    reply_sender_id     : null,
    reply_img           : null,
    reply_sender_login  : null
}
function clearTmpMsg() {
        G_tmp_msg.id                  = null;
        G_tmp_msg.sender_id           = null;
        G_tmp_msg.consumer_id         = null;
        G_tmp_msg.content             = null;
        G_tmp_msg.img                 = null;
        G_tmp_msg.img_icon            = null;
        G_tmp_msg.view                = null;
        G_tmp_msg.create_date         = null;
        G_tmp_msg.ads_id              = null;
        G_tmp_msg.discus_id           = null;
        G_tmp_msg.create_id           = null;
        G_tmp_msg.reply_msg_id        = null;
        G_tmp_msg.reply_content       = null;
        G_tmp_msg.reply_sender_id     = null;
        G_tmp_msg.reply_img           = null;
        G_tmp_msg.reply_sender_login  = null;
}