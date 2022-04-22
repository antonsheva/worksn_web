var msgVars = {
    discusId   : null,
    senderId   : null,
    consumerId : null,
    speakerId  : null,
    messages   : []
};
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
};
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
var msgParams = {
    color      : null,
    align      : null,
    status     : null,
    statusImg  : null,
    content    : null,
    description: null,
    msgImg     : null,
    msgImgIcon : null,
    tm         : null,

    replyMsgId       : null,
    replyMsgImg      : null,
    replyMsgContent  : null,
    replySenderId    : null,
    replySenderLogin : null,

    msgImgDisplay   : 'none',
    replyDisplay    : 'none',
    replyImgDisplay : 'none'

};
function clearMsgParams() {
    msgParams.color      = null;
    msgParams.align      = null;
    msgParams.status     = null;
    msgParams.statusImg  = null;
    msgParams.content    = null;
    msgParams.description= null;
    msgParams.msgImg     = null;
    msgParams.msgImgIcon = null;
    msgParams.tm         = null;
    msgParams.replyMsgId       = null;
    msgParams.replyMsgImg      = null;
    msgParams.replyMsgContent  = null;
    msgParams.replySenderId    = null;
    msgParams.replySenderLogin = null;

    msgParams.msgImgDisplay   = 'none';
    msgParams.replyDisplay    = 'none';
    msgParams.replyImgDisplay = 'none';
}