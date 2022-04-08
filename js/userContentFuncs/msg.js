function sendMsg(data) {
    if((!data.content)&&(!G_tmp_img))return;
    if(!data.content)data.content = ' ';
    G_.msg.content = data.content;


    delete data.bt;
    data.act = 'add_msg';
    data.sender_id   = G_.user.id;
    data.consumer_id = discusVars.speaker.id;
    data.ads_id      = discusVars.ads.id ;
    if(data.ads_id == null)data.ads_id = 1;
    renderTmpImgBox(null);

    if(G_tmp_msg.reply_msg_id){
        data.reply_msg_id       = G_tmp_msg.reply_msg_id       ;
        data.reply_content      = G_tmp_msg.reply_content      ;
        data.reply_sender_id    = G_tmp_msg.reply_sender_id    ;
        data.reply_sender_login = G_tmp_msg.reply_sender_login ;
        if(G_tmp_msg.reply_img)
            data.reply_img = G_tmp_msg.reply_img;
    }

    APost(data, cbSendMsg);
    data = null;
}
function chooseImg(id) {
    if(!G_.user.id)return;
    var selector = '#'+id+' img';
    pressButtonAnime($(selector), '#9ddba5');
    sendFile();
    G_tmpImgState = C_IMG_MSG;
}
function getDiscusWithUser(id) {
    data = {};
    data.act = 'get_user_msg';
    data.speaker_id = id;
    APost(data, cbGetMsgGroup);
}
function getMsgGroup(act) {
    render.noChangeScreen = true;
    G_globalMode = C_MODE_MAIN;
    highlightTabAdsParam(null)
    if(!CNTXT_.user.id){APopUpMessage('Войдите в учетную запись', 1);return;}
    data = {};
    data.act = act;
    APost(data, cbGetMsgGroup);
}
function getMsgChain(discus_id) {
    if(!CNTXT_.user.id){APopUpMessage('Войдите в учетную запись', 1);return;}
    data = {};
    data.act = 'get_chain_msg';
    data.discus_id = discus_id;
    APost(data, cbGetDiscus);
}
function getDiscusForAds(ads_id, consumer_id) {
    data = {};
    data.act = 'get_discus_for_ads';
    data.ads_id = ads_id;
    data.consumer_id = consumer_id;
    data.sender_id = CNTXT_.user.id;

    APost(data, cbGetDiscus);
}
function checkNewMsg() {
    data = {};
    if(!CNTXT_.user.id){APopUpMessage('Войдите в учетную запись', 1);return;}
    data.act = 'check_new_msg';
    APost(data, cbCheckNewMsg)
}

function cbCheckNewMsg(data){
    enableBell(data.result)
}
function cbGetMsgGroup(data) {

    var error  = Number.parseInt(data.error);
    var result = Number.parseInt(data.result);
    var msg = data.response;
    if(data.act === ACT_GET_NEW_MSG)enableBell(result)
    if(error === 0){
        if(result === 0){
            if(localStorage.getItem('mode') == MODE_DISCUS_WITH_USER){
                createDiscusWithUser();
            }else {
                msg = data.data;
                APopUpMessage(msg);
            }
        }else {
            renderScreenMsgGroupList();
            if(CNTXT_.messages){
                userVars.targetUsers = [];
                printMessagesGroup(CNTXT_.messages);
                $.each(CNTXT_.messages, function (index, item) {
                    if (userVars.targetUsers.indexOf(item.speaker_id) === -1)
                        userVars.targetUsers.push(item.speaker_id)
                })
                wsCheckUsersGroupStatus();
            }
            localStorage.setItem('mode', MODE_MAIN);
        }
    }else{
        msg = data.data;
        printSysMsg(msg);
    }
}

function cbGetDiscus(data){
    var error  = Number.parseInt(data.error);
    var result = Number.parseInt(data.result);
    var msg = data.response;
    if(error === 0) {
        saveDiscusData();
        if(G_cntxt.user.id){
            initDiscusCard(discusVars.speaker);
            renderScreenMsgChainList();
            checkNewMsg();
            $('#frmSendMsgForm .content').focus();
        }else {
            initDiscusCard(discusVars.owner);
            renderScreenMsgChainList();
            renderMessagesScreen(0);
        }
    }else{
        msg = data.data;
    }
}
function cbSendMsg(data) {
    data = CNTXT_.target_msg;
    discusVars.messages.push(data);
    clearTmpMsg();
    hideReplyToMsgForm();
    data.view = 0;
    try {
        addMsgToMsgFrame(data, true);
    }catch (e){}
    $('#frmSendMsgForm .content').val('');
    $('.content').val('');
    d = {};
    d.act           = ACT_NEW_MSG;
    d.id            = data.id;
    d.discus_id     = data.discus_id;
    d.ads_id        = data.ads_id;
    d.sender_id     = data.sender_id;
    d.sender_login  = CNTXT_.user.login;
    d.sender_avatar = CNTXT_.user.img_icon;
    d.consumer_id   = data.consumer_id;
    d.content       = data.content;
    d.img           = data.img;
    d.img_icon      = data.img_icon;
    d.create_date   = data.create_date;

    if(data.reply_msg_id){
        d.reply_msg_id       = data.reply_msg_id;
        d.reply_content      = data.reply_content;
        d.reply_sender_id    = data.reply_sender_id;
        d.reply_sender_login = data.reply_sender_login;
        if (data.reply_img)d.reply_img = data.reply_img;
    }

    wsSendData(d)
}
function cbRmvMsg(data) {
    var error = Number.parseInt(data.error);
    if(error === 0){
        $('#'+G_tmp_obj.target_id).remove();
    }

}

function rmvMsg(id) {
    subMenuHidden();
    data = {};
    data.act = 'rmvMsg';
    data.id = id;
    APost(data, cbRmvMsg);
}
function rmvDiscus(id){
    if(confirm('Удалить диалог?')) {
        data = {};
        data.act = 'rmvDiscus';
        data.id = id;
        APost(data, cbRmvMsg);
    }
}

function wsRcvNewMsg(data){
    if(!discusVars.discus){
        enableBell(1);
        return;
    }

    sender_id = data.sender_id;
    discus_id = data.discus_id;
    if(data.discus_id == discusVars.discus.id){
        discusVars.messages.push(data);
        $('.messagesFrame').scrollTop(0);
        addMsgToMsgFrame(data, false);

        if (localStorage.getItem(VIEW_MSG) === 'true')
            wsSendMsgStatus(sender_id, discus_id, 2);

    }
    else {
        if (localStorage.getItem(DELIVER_MSG) === 'true')
            wsSendMsgStatus(sender_id, discus_id, 1);

        enableBell(1);
    }
}
function wsRcvWriteMsgProcess() {
    if (data.discus_id == discusVars.discus.id)
        frmWriteMsgProcess();
}
function wsRcvConfirmViewedMsg(data) {
    if(!discusVars.discus){
        return;
    }
    if(data.discus_id == discusVars.discus.id){
        renderMsgStatus(data.status_msg);
    }
}
function wsRcvConfirmDeliverMsg(data) {
    if(data.discus_id == G_.msg.discus_id){
        $('.messagesFrame [data-status='+0+']').attr('src','/service_img/design/birdie_1.bmp');
        $('.messagesFrame [data-status='+0+']').attr('data-status',1);
    }
}

function startWriteProcessTimer() {
    if(!discusVars.writeMsgProcessTimer){
        discusVars.writeMsgProcessTimer = true;
        wsSendPrintMsgProcess();
        setTimeout(function () {
            discusVars.writeMsgProcessTimer = false;
        }, 5000)
    }
}
function saveDiscusData() {
    discusVars.discus   = CNTXT_.discus;
    discusVars.messages = CNTXT_.messages;
    discusVars.owner    = CNTXT_.owner;
    discusVars.speaker  = CNTXT_.speaker;
    discusVars.ads      = CNTXT_.target_ads;
}

function createDiscusWithUser() {
    data = {};
    data.act = 'get_discus_for_ads';
    data.ads_id = ADS_ID_FOR_DIRECT_DISCUS;
    data.consumer_id = localStorage.getItem('user_id');
    data.sender_id = CNTXT_.user.id;

    APost(data, cbGetDiscus);
    localStorage.setItem('mode', MODE_MAIN);
}

