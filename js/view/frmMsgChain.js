function frmMsgChain(msg, status) {
    var id = 'msg_'+G_.cnt++;
    var scrollId;
    var replyImg;
    var frm;
    getFrameParameters(msg);
    scrollId = 'scroll_'+msg.id;
    replyImg = !msgParams.replyMsgImg ? '' : '' +
        '<object data="'+msgParams.replyMsgImg+'" style="display: '+msgParams.replyImgDisplay+'">' +
             ''+
        '</object>';
    frm =  '' +
        '<div id="'+id+'" style="text-align: '+msgParams.align+'">' +
        '   <div class="frmMsgChain" style="background-color: '+msgParams.color+'" data-msg_id="'+msg.id+'">' +
        '       <div class="reply"  style="display: '+msgParams.replyDisplay+'" data-scroll_id="scroll_'+msgParams.replyMsgId+'">' +
        '           <a class="login" >'+msgParams.replySenderLogin+'</a>' +
        '           <div>' +
                        replyImg+
        '               <a class="content">'+msgParams.replyMsgContent+'</a>' +
        '           </div>' +
        '       </div>' +
        '       <div id="'+scrollId+'" class="msgNew">' +
        '           <div class="msgImg" data-img="'+msgParams.msgImg+'" data-img_id="'+msg.id+'" style="display: '+msgParams.msgImgDisplay+'">' +

        '               <object data="'+msgParams.msgImgIcon+'" data-img_icon_id="'+msg.id+'">' +
        '               </object>' +
        '           </div>' +
        '           <a id="'+id+'_copy" class="content" name="'+id+'">'+msgParams.content+'</a>' +
        '           <div style="padding-top: 5px; display: block; position: relative">' +
        '                <a  class="time">'+msgParams.tm+'</a>' +
        '                <img class="confirmMsg" src="'+msgParams.statusImg+'" data-status="'+msgParams.status+'">'+
        '           </div>' +
        '       </div>' +
        '   </div>' +
        '</div>';
    return frm;
}

function getFrameParameters(msg) {
    clearMsgParams();
    var view = Number.parseInt(msg.view);
    if(!view)msgParams.status = MSG_STATUS_NOT_DELIVER;
    if(parseInt(msg.sender_id) === parseInt(CNTXT_.user.id)){
        msgParams.color  = '#d6ebdf';
        msgParams.align  = 'right';
        msgParams.status = view;
    }else {
        msgParams.color  = '#cce1ee';
        msgParams.align  = 'left';
        msgParams.status = MSG_STATUS_UNDEFINED;
    }
    switch (msgParams.status){
        case MSG_STATUS_NOT_DELIVER : msgParams.statusImg = URL_IMG_BIRDIE_1     ; break;
        case MSG_STATUS_DELIVER     : msgParams.statusImg = URL_IMG_BIRDIE_2     ; break;
        case MSG_STATUS_READ        : msgParams.statusImg = URL_IMG_BIRDIE_3     ; break;
        default                     : msgParams.statusImg = URL_IMG_EMPTY        ;
    }
    getMsgImage(msg);
    getContentData(msg);

    if (msgParams.replyMsgId)msgParams.replyDisplay = 'block';
    if (msgParams.replyMsgImg)msgParams.replyImgDisplay = 'block';
    if (msgParams.msgImg)msgParams.msgImgDisplay = 'block';
}

function getContentData(msg) {
     

    msgParams.tm = msg.create_date ? msg.create_date : '--:--';
    msgParams.content = msg.content ? msg.content : ' ';

    if(!msg.reply_msg_id) return;



    msgParams.replyMsgId       = Number.parseInt(msg.reply_msg_id);
    msgParams.replyMsgContent  = msg.reply_content;
    msgParams.replyMsgImg      = msg.reply_img;
    msgParams.replySenderId    = Number.parseInt(msg.reply_sender_id);
    msgParams.replySenderLogin = msg.reply_sender_login;

    if(msgParams.replySenderLogin === CNTXT_.user.login)
        msgParams.replySenderLogin = STRING_YOU;


}

function getMsgImage(msg) {
    if(!msg.img)msgParams.msgImg = '';
    else if (msg.img === STR_WAS_SEND_POST_DATA)
        msgParams.msgImg  = URL_IMG_GALLERY;
    else
        msgParams.msgImg  = msg.img;

    if(!msg.img_icon) msgParams.msgImgIcon  = '';
    else if (msg.img_icon === STR_WAS_SEND_POST_DATA)
        msgParams.msgImgIcon = URL_IMG_GALLERY;
    else
        msgParams.msgImgIcon = msg.img_icon;

}

function addMsgToMsgFrame(msg, clrInputField) {
    $('.messagesFrame').append(frmMsgChain(msg, 1));
    $('.messagesFrame').scrollTop($('.messagesFrame')[0].scrollHeight);
}