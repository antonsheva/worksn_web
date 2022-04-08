$(function () {
    $("#add_avatar input[type=file]").on('change', function(){
        var tmp;
        tmp = $("#add_avatar input[type=file]").val();
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
    })
    // $(".gallerySign").on('click', function(){
    //     if(!G_.user.id)return;
    //     pressButtonAnime(this, '#9ddba5');
    //     sendFile();
    //     G_tmpImgState = C_IMG_MSG;
    // });
    $('.tmpImgBox #imgBox').on('click', function (e) {
        switch (G_tmpImgState){
            case C_IMG_ZOOM  : renderTmpImgBox(0)   ;break;
            case C_IMG_SUBMIT: removeImg(G_tmp_img)      ;
                               renderTmpImgBox(null); break;
        }
    })
    $('#msgWindow .appendData').on('mousedown', function (e) {
        subMenuHidden();
    })
    $('.closeImgGroup').on('click', function (e) {
        renderTmpImgGroup(null);
    })
    $('#frmSendMsgForm .content').focus(function (e) {
        renderMessagesScreen(1);
    });

/////////////////////////////////////////////////////////////////////////
//  hiding a submenu when clicking on a outside the submenu border     //
    $('body').on('touchstart mousedown', function (e) {
        subMenuHidden();
    })
//  undoing submenu hiding                                             //
    $('.subMenu').on('touchstart mousedown', function (e) {
        e.preventDefault();
        e.stopPropagation();
    })
/////////////////////////////////////////////////////////////////////////

    $('.messagesFrame').on("contextmenu", false);
    $('#msgWindow .appendData').on("contextmenu", false);
    $('#frmVisibleAds .appendData').on("contextmenu", false);

    $('.buttonGenerateAds').on('click', function (e) {

        var date = {act:'create_tmp_ads'};

        APost(date,function (data) {

        });


    });

    G_cntxt = StructContext;


    AStart();
});



