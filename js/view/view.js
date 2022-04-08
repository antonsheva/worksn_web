function printSysMsg(msg){
    var div = '' +
        '<div>' +
        '   <a>'+msg+'</a>' +
        '</div>';
    $('#msgWindow .appendData').empty();
    $('#msgWindow .appendData').append(div);
}
function enableBell(swch) {
    data = parseInt(swch);
    if(data === 1){
        $('.newMsg > img').attr('src','../../../service_img/design/bell_act.png');
    }else{
        $('.newMsg > img').attr('src','../../../service_img/design/no_bell.png');
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
    time = CNTXT_.owner.last_time;
    if(status){
        $('#userProfile .last_time').html('<a style="color: cornflowerblue">сейчас в сети</a>');
        $('.userState').html('<a style="color: green; font-size: 12px">в сети</a>');
    }else{
        $('#userProfile .last_time').html('<a style="color: grey">был в сети '+time+'</a>');
    }
}

function showReplyToMsgForm() {

    var msg = null;
    var id = G_tmp_obj.id;

    $.each(discusVars.messages, function (index, val) {
        if (parseInt(val.id) === parseInt(id))
            msg = val;
    })



    var login = (msg.sender_id == CNTXT_.user.id) ? 'Вы' : CNTXT_.speaker.login;

    clearTmpMsg();
    $('.replyToMsgForm').css('display', 'block');
    $('.replyToMsgForm .login').text(login);
    $('.replyToMsgForm .content a').text(msg.content);

    if(msg.img_icon){
        if(msg.img_icon.length > 5){
            $('.replyToMsgForm .img').css('display', 'block');
            $('.replyToMsgForm .img').attr('src', msg.img_icon);
            G_tmp_msg.reply_img = msg.img_icon;
        }
    }
    subMenuHidden();
    $('#sendForm input').focus();



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


