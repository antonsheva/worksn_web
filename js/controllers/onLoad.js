$(function () {
    $("#add_avatar").find('input[type=file]').on('change', function(){
        var tmp;
        tmp = $(this).val();
        if(tmp){
            files = this.files;
            ASubmitImg();
            if(G_imgType === C_IMG_MSG){
                renderTmpImgBox(true);
                renderImgMsgForm(true);
            }
            G_tmpImgState = C_IMG_SUBMIT;
        }
    });
    $('.userAvatar').on('click', function (e) {
            changeImg(null);
    });
    $('.tmpImgBox #imgBox').on('click', function (e) {
        switch (G_tmpImgState){
            case C_IMG_ZOOM  : renderTmpImgBox(0)   ;break;
            case C_IMG_SUBMIT: removeImg(G_tmp_img)      ;
                               renderTmpImgBox(null); break;
        }
    });
    $('#msgWindow').find('.appendData').on('mousedown', function (e) {
        subMenuHidden();
    });
    $('.closeImgGroup').on('click', function (e) {
        renderTmpImgGroup(null);
    });
    $('#frmSendMsgForm').find('.content').focus(function (e) {
        renderMessagesScreen(1);
    });
    $('body').on('touchstart mousedown', function (e) {
        subMenuHidden();
    });
    $('.subMenu').on('touchstart mousedown', function (e) {
        e.preventDefault();
        e.stopPropagation();
    })
    $('.messagesFrame').on("contextmenu", false);
    $('#msgWindow .appendData').on("contextmenu", false);
    $('#frmVisibleAds .appendData').on("contextmenu", false);

    $('.buttonGenerateAds').on('click', function (e) {
        var date = {act: ACT_CREATE_TMP_ADS};
        APost(date,function (data) {
        });
    });

    G_cntxt = StructContext;
    AStart();
});



