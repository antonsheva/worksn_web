$(function () {
    var tm = null;

    $('#msgWindow').on('touchstart mousedown','.frmMsgGroup',function (e) {
        fixEventData(this,e, e.type);
        tm = setTimeout(showSubMenu, 500)

        G_tmp_obj.type        = 'msgGroup';
        G_tmp_obj.target_id   = $(this).attr('id');
        G_tmp_obj.id          = msgVars.messages[G_tmp_obj.target_id].discus_id;
    });
    
    $('#msgWindow').on('touchmove','.frmMsgGroup',function (e) {
        clearTimeout(tm);
        G_event.click = C_DESABLE;
    })
    $('#msgWindow').on('click touchend', '.frmMsgGroup .bcgrnd', function (e) {

        var c = $(this).attr('class');
        if(eventDisable())return;
        var discus_id = msgVars.messages[G_tmp_obj.target_id].discus_id;
        getMsgChain(discus_id);
        G_imgType = C_IMG_MSG;
        clearTimeout(tm);
    });

    $('#msgWindow').on('touchend click',  '.frmMsgGroup',function (e) {
        clearTimeout(tm);
    })
})
