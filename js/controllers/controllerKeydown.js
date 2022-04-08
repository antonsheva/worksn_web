$(function () {
    $('#loginForm').keydown(function (e) {
        if(e.which ===13){
            ALogin(GP('loginForm'));
        }
    })
    $('#frmSendMsgForm .content').keydown(function (e) {
        if(e.which ===13){
            sendMsg(GP('frmSendMsgForm'))
        }else {
            startWriteProcessTimer();
        }
    })
    $('#sendImgMsg .content').keydown(function (e) {
        if(e.which ===13){
            sendMsg(GP('sendImgMsg'))
        }else {
            startWriteProcessTimer();
        }
    })
    $('.txt_review').keydown(function (e) {
        if(e.which ===13){
            sendUserReviewTxt(GP('userProfile'))
            $('.txt_review').blur();
        }
    })
    $('#frmSearch').find('.content').keydown(function (e) {
        if(e.which ===13){
            searchAds(GP('frmSearch'))
            $('#searchForm').find('.content').blur();
        }
    })
})