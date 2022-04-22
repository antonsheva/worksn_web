var frmImgGroup_tm;
$(function () {
    if ('ontouchstart' in window) {
        $('.tmpImgGroup').on('touchstart','.frm_ads_img',function (e) {
            tmFrmImgGroupSubMenu(this, e);
        }).on('touchend','.adsImg',function (e) {
            img = $(this).attr('data-img');
            zoomImg(img);
            e.preventDefault();
        })
    }else{
        $('.tmpImgGroup').on('mousedown','.frm_ads_img',function (e) {
            tmFrmImgGroupSubMenu(this, e);
        }).on('click','.adsImg',function (e) {
            img = $(this).attr('data-img');
            zoomImg(img);
        }).on('click','.frm_ads_img',function (e) {
            rmvSgn(this, e);
        })
    }
    controllerFrmImgGroupClick();
});
function controllerFrmImgGroupClick() {
    $(".tmpImgGroup").on("contextmenu", false)
        .on('touchmove','.frm_ads_img',function (e) {
            clearTimeout(frmImgGroup_tm);
            G_event.click = C_DISABLE;
        }).on('touchend click',  '.frm_ads_img',function (e) {
        clearTimeout(frmImgGroup_tm);
    });
}
function tmFrmImgGroupSubMenu(obj, e) {
    if(eventDisable())return;
    fixEventData(obj, e, e.type);
    frmImgGroup_tm  = setTimeout(showSubMenu, 500)
    G_tmp_obj.type        = 'imgGroup';

    G_tmp_obj.filename   = $(obj).children('[name=imgName]').data('name');
    G_tmp_obj.target_id   = $(obj).attr('id');
    G_tmp_obj.confirm_msg = null;
}