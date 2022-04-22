$(function () {
    var frmMsgChain_tm;
    $(".messagesFrame").on("contextmenu", false);
    $('.messagesFrame').on('touchstart mousedown','.frmMsgChain',function (e) {
        fixEventData(this, e, e.type)
        frmMsgChain_tm  = setTimeout(showSubMenu, 500);
        var msgId = $(this).data('msg_id');
        G_tmp_obj.type        = 'msgChain';
        G_tmp_obj.id          = msgId;
        G_tmp_obj.target_id   = $(this).parent().attr('id');
        G_tmp_obj.confirm_msg = null;
        G_tmp_obj.cbFunc      = cbRmvMsg;
    });
    $('.messagesFrame').on('click touchend','.msgImg',function (e) {
        e.preventDefault();
        img = $(this).attr('data-img');
        zoomImg(img);
    })

    $('.messagesFrame').on('click touchend','.reply',function (e) {
        e.preventDefault();
        var scrollId = $(this).attr('data-scroll_id');
        scrollToView(scrollId);
    })


    $('.messagesFrame').on('touchmove','.frmMsgChain',function (e) {
        clearTimeout(frmMsgChain_tm);
        G_event.click = C_DISABLE;
    });
    $('.messagesFrame').on('touchmove','.msgImg',function (e) {
        clearTimeout(frmMsgChain_tm);
        G_event.click = C_DISABLE;
    });
    $('.messagesFrame').on('touchend click',  '.frmMsgChain',function (e) {
        e.preventDefault();
        clearTimeout(frmMsgChain_tm);
    });
});
function rmvSgn(obj, e) {
    objType = $(obj).attr('class');
    if(eventDisable())return;
    var discus_id = $(obj).children('[name=discus_id]').data('id');
    var msg_id = $(obj).children('[name=msg_id]').data('id');

    G_tmp_obj.target_id = $(obj).attr('id');
    if(objType === 'frmMsgChain')rmvMsg(msg_id);
    if(objType === 'frmMsgGroup')rmvDiscus(discus_id);
    G_.msg_id    = msg_id;
}