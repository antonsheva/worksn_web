function enableBell(swch) {
    var data = parseInt(swch);
    if(data === 1){
        $('.newMsg > img').attr('src',URL_IMG_BELL_ACT);
    }else{
        $('.newMsg > img').attr('src',URL_IMG_BELL_NO_ACT);
    }
}
function APopUpMessage(msg, color){
    var len = msg.length;
    var tm = len*50;
    if(tm<1000)tm = 1000;
    if(color)$('body').append('<div id="popup_msg" class="kant_msg" style="background-color: #ffa427"><a>'+msg+'</a></div>');
    else     $('body').append('<div id="popup_msg" class="kant_msg" style="background-color: #bbeaab"><a>'+msg+'</a></div>');
    $('#popup_msg').animate({opacity: 1}, 200);
    setTimeout(function(){
        $('#popup_msg').animate({opacity: 0}, 200);
    }, tm);
    setTimeout(function(){
        $('#popup_msg').remove();
    }, tm+1000);
}
function vwUserStatus(status) {
    var time = CNTXT_.owner.last_time;
    if(status){
        $('#userProfile').find('.last_time').html('<a style="color: cornflowerblue">'+STRING_NOW_ONLINE+'</a>');
        $('.userState').html('<a style="color: green; font-size: 12px">'+STRING_ONLINE+'</a>');
    }else{
        $('#userProfile').find('.last_time').html('<a style="color: grey">'+STRING_WAS_ONLINE+time+'</a>');
    }
}
function showReplyToMsgForm() {
    var msg = null;
    var id  = G_tmp_obj.id;
    var login;
    $.each(discusVars.messages, function (index, val) {
        if (parseInt(val.id) === parseInt(id))
            msg = val;
    });

    login = (parseInt(msg.sender_id) === parseInt(CNTXT_.user.id)) ? 'Вы' : CNTXT_.speaker.login;
    clearTmpMsg();
    $('.replyToMsgForm').css('display', 'block');
    $('.replyToMsgForm .login').text(login);
    $('.replyToMsgForm .content a').text(msg.content);

    if(msg.img_icon){
        if(msg.img_icon.length > 5){
            $('.replyToMsgForm').find('.img').css('display', 'block')
                                             .attr('src', msg.img_icon);
            G_tmp_msg.reply_img = msg.img_icon;
        }
    }
    subMenuHidden();
    $('#sendForm').find('input').focus();

    G_tmp_msg.reply_msg_id       = msg.id;
    G_tmp_msg.reply_content      = msg.content;
    G_tmp_msg.reply_sender_id    = msg.sender_id;
    G_tmp_msg.reply_sender_login = login;

    msg = null;
}
function hideReplyToMsgForm() {
    $('.replyToMsgForm').css('display', 'none');
    $('.replyToMsgForm .img').css('display', 'none');
}
function scrollToView(id) {
    var elem = document.getElementById(id);
    elem.scrollIntoView();
}
function highlightStars(qt) {
    for(i=1; i<=5; i++)
        $('[data-star_numb='+i+'] img').attr('src', URL_IMG_STAR_EMPTY);

    for(i=1; i<=qt; i++)
        $('[data-star_numb='+i+'] img').attr('src', URL_IMG_STAR_OK);

}

