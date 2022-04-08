var params = {
    color      : null,
    align      : null,
    status     : null,
    statusImg  : null,
    content    : null,
    description: null,
    msgImg     : null,
    msgImgIcon : null,
    tm         : null,

    replyMsgId       : null,
    replyMsgImg      : null,
    replyMsgContent  : null,
    replySenderId    : null,
    replySenderLogin : null,

    msgImgDisplay   : 'none',
    replyDisplay    : 'none',
    replyImgDisplay : 'none'

};
function clearMsgParams() {
        params.color      = null;
        params.align      = null;
        params.status     = null;
        params.statusImg  = null;
        params.content    = null;
        params.description= null;
        params.msgImg     = null;
        params.msgImgIcon = null;
        params.tm         = null;
        params.replyMsgId       = null;
        params.replyMsgImg      = null;
        params.replyMsgContent  = null;
        params.replySenderId    = null;
        params.replySenderLogin = null;

        params.msgImgDisplay   = 'none';
        params.replyDisplay    = 'none';
        params.replyImgDisplay = 'none';
}

function frmMsgChain(msg, status) {
    var id = 'msg_'+G_.cnt++;
    getFrameParameters(msg);
    var scrollId = 'scroll_'+msg.id;
    var replyImg = !params.replyMsgImg ? '' : '' +
        '<object data="'+params.replyMsgImg+'" style="display: '+params.replyImgDisplay+'">' +
             ''+
        '</object>';
    return '' +
        '<div id="'+id+'" style="text-align: '+params.align+'">' +
        '   <div class="frmMsgChain" style="background-color: '+params.color+'" data-msg_id="'+msg.id+'">' +
        '       <div class="reply"  style="display: '+params.replyDisplay+'" data-scroll_id="scroll_'+params.replyMsgId+'">' +
        '           <a class="login" >'+params.replySenderLogin+'</a>' +
        '           <div>' +
                        replyImg+
        '               <a class="content">'+params.replyMsgContent+'</a>' +
        '           </div>' +
        '       </div>' +
        '       <div id="'+scrollId+'" class="msgNew">' +
        '           <div class="msgImg" data-img="'+params.msgImg+'" data-img_id="'+msg.id+'" style="display: '+params.msgImgDisplay+'">' +

        '               <object data="'+params.msgImgIcon+'" data-img_icon_id="'+msg.id+'">' +
        '               </object>' +

        // '                <img src="'+params.msgImgIcon+'" data-img_icon_id="'+msg.id+'">' +


        '           </div>' +
        '           <a id="'+id+'_copy" class="content" name="'+id+'">'+params.content+'</a>' +
        '           <div style="padding-top: 5px; display: block; position: relative">' +
        '                <a  class="time">'+params.tm+'</a>' +
        '                <img class="confirmMsg" src="'+params.statusImg+'" data-status="'+params.status+'">'+
        '           </div>' +
        '       </div>' +
        '   </div>' +
        '</div>';
}




function getFrameParameters(msg) {
    clearMsgParams();
    var view = Number.parseInt(msg.view);
    if(!view)params.status = 0;
    if(msg.sender_id == CNTXT_.user.id){
        params.color  = '#d6ebdf';
        params.align  = 'right';
        params.status = view;
    }else {
        params.color  = '#cce1ee';
        params.align  = 'left';
        params.status = 3;
    }
    switch (params.status){
        case 0 : params.statusImg = '/service_img/design/birdie_1.bmp'     ; break;
        case 1 : params.statusImg = '/service_img/design/birdie_2.bmp'     ; break;
        case 2 : params.statusImg = '/service_img/design/birdie_3.bmp'     ; break;
        default: params.statusImg = '/service_img/design/empty_100_100.gif';
    }
    getMsgImage(msg);
    getContentData(msg);

    if (params.replyMsgId)params.replyDisplay = 'block';
    if (params.replyMsgImg)params.replyImgDisplay = 'block';
    if (params.msgImg)params.msgImgDisplay = 'block';
}

function getContentData(msg) {
     

    params.tm = msg.create_date ? msg.create_date : '--:--';
    params.content = msg.content ? msg.content : ' ';

    if(!msg.reply_msg_id) return;



    params.replyMsgId       = Number.parseInt(msg.reply_msg_id);
    params.replyMsgContent  = msg.reply_content;
    params.replyMsgImg      = msg.reply_img;
    params.replySenderId    = Number.parseInt(msg.reply_sender_id);
    params.replySenderLogin = msg.reply_sender_login;

    if(params.replySenderLogin === CNTXT_.user.login)
        params.replySenderLogin = 'Вы';


}

function getMsgImage(msg) {
    if(!msg.img)params.msgImg = '';
    else if (msg.img == 'was_send_post_data')
        params.msgImg  = '/service_img/design/gallery.gif';
    else
        params.msgImg  = msg.img;

    if(!msg.img_icon) params.msgImgIcon  = '';
    else if (msg.img_icon == 'was_send_post_data')
        params.msgImgIcon = '/service_img/design/gallery.gif';
    else
        params.msgImgIcon = msg.img_icon;

}

function addMsgToMsgFrame(msg, clrInputField) {
    $('.messagesFrame').append(frmMsgChain(msg, 1));
    $('.messagesFrame').scrollTop($('.messagesFrame')[0].scrollHeight);
}