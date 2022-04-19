var frmImgGroup_tm;
$(function () {
    $(".tmpImgGroup").on("contextmenu", false);
    if ('ontouchstart' in window) {
        $('.tmpImgGroup').on('touchstart','.frm_ads_img',function (e) {
            tmFrmImgGroupSubMenu(this, e);
        });
        $('.tmpImgGroup').on('touchend','.adsImg',function (e) {
            img = $(this).attr('data-img');
            zoomImg(img);
            e.preventDefault();
        })
    }else{
        $('.tmpImgGroup').on('mousedown','.frm_ads_img',function (e) {
            tmFrmImgGroupSubMenu(this, e);
        });
        $('.tmpImgGroup').on('click','.adsImg',function (e) {
            img = $(this).attr('data-img');
            zoomImg(img);


            // zoomImg(this);
        });
        $('.tmpImgGroup').on('click','.frm_ads_img',function (e) {
            rmvSgn(this, e);
        })
    }
    $('.tmpImgGroup').on('touchmove','.frm_ads_img',function (e) {
        // e.preventDefault();
        clearTimeout(frmImgGroup_tm);
        G_event.click = C_DESABLE;
    });
    $('.tmpImgGroup').on('touchend click',  '.frm_ads_img',function (e) {
        clearTimeout(frmImgGroup_tm);
    });
});
function tmFrmImgGroupSubMenu(obj, e) {
    if(eventDisable())return;
    fixEventData(obj, e, e.type);
    frmImgGroup_tm  = setTimeout(showSubMenu, 500)
    G_tmp_obj.type        = 'imgGroup';

    G_tmp_obj.filename   = $(obj).children('[name=imgName]').data('name');
    G_tmp_obj.target_id   = $(obj).attr('id');
    G_tmp_obj.confirm_msg = null;
}