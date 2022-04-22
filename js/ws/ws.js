function initSocket() {
        wsVars.socket = new WebSocket(URL_WS);
        wsVars.socket.onopen = function () {
            wsVars.state = C_OPEN;
        };
        wsVars.socket.onerror = function (e) {
            wsVars.socket.close();
            wsReset();
        };

        wsVars.socket.onclose = function () {
            wsReset();
        };

        wsVars.socket.onmessage = function (event) {
            data = $.parseJSON(event.data);
            switch (data.type){

                case ACT_CONFIRM_DELIVER_MSG    : wsRcvConfirmViewedMsg(data);  break;
                case ACT_NEW_MSG                : wsRcvNewMsg(data);            break;
                case ACT_PING                   : wsRcvPing();                  break;
                case ACT_ONLINE_LIST            : wsRcvOnlineUsers(data);       break;
                case ACT_AUTH_USER              : wsRcvAuthUser(data);          break;
                case ACT_EXIT                   : wsRcvExit();                  break;
                case ACT_NEW_AUTH_DATA          : wsRcvNewAuthData();           break;
                case ACT_PRINT_MSG_PROCESS      : wsRcvWriteMsgProcess(data);   break;
                case ACT_BIND_IMG_TO_MSG        : wsRcvBindImgToMsg(data)
            }
        }
}
function wsCheckSocketConnection() {
    if(!wsVars.state && (G_.user.id !== null)){
        initSocket();
    }
    if((wsVars.state === C_OPEN)&&(!wsVars.auth_user)&&(G_.user.id !== null)){
        wsSendAuthUser();
    }
}
function wsReset() {
    wsVars.socket     = null;
    wsVars.port       = null;
    wsVars.address    = null;
    wsVars.error      = null;
    wsVars.state      = null;
    wsVars.auth_user  = null;
}
function wsCheckOwnerStatus() {
    var cnt = 0;
    var tm = setInterval(function () {
        if(wsVars.state === C_OPEN){
            wsSendGetOnlineStatus(CNTXT_.owner.id);
            clearTimeout(tm);
        }
        cnt++;
        if(cnt>10){
            vwUserStatus(0);
            clearTimeout(tm);
        }
    }, 200);
}
function wsCheckUsersGroupStatus() {
    var idList = '';
    if ((!userVars.targetUsers)||(userVars.targetUsers.length === 0))return;
    $.each(userVars.targetUsers, function (index, item) {
        idList += item + '_';
    });
    idList = idList.substr(0, idList.length-1);
    if (!idList)return;
    wsSendGetOnlineStatus(idList);
}
function wsRcvBindImgToMsg(data) {
    var id = data.msg_id;
    $('.messagesFrame').find("[data-img_icon_id="+id+"]").attr('data',data.img_icon);
    $('.messagesFrame').find("[data-img_id="+id+"]").attr('data-img',data.img);
}
function wsRcvOnlineUsers(data) {
    G_netStatus = null;
    G_netStatus = data.id_list.split('_');
    $.each(G_netStatus, function (key, val) {
        if (isNaN(+val))delete G_netStatus[key];
    });
    $.each(userVars.targetUsers, function (index, id) {
            if(G_netStatus.indexOf(id) === -1){
                $('.online'+'.'+id).css('display','none');
            }else{
                $('.last_time').text(STRING_NOW_ONLINE);
                $('.online'+'.'+id).css('display','block');
            }
    })
}
function wsRcvExit() {
    var data = {act: ACT_EXIT};
    wsSendData(data);
    wsReset();
}
function wsRcvPing() {
    var data = {act: ACT_PONG};
    data.login = CNTXT_.user.login;
    wsSendData(data);
}
function wsRcvNewAuthData() {
    APopUpMessage(STRING_SIGN_IN_FROM_OTHER_DEVICE, 1);
    AExit(false);
}
function wsRcvAuthUser(data) {
    wsVars.auth_user = 1;
    wsCheckUsersGroupStatus();
}
function wsSendAuthUser() {
    var data = {act: ACT_AUTH_USER};
    data.user_id    = CNTXT_.user.id;
    data.user_login = CNTXT_.user.login;
    data.ws_token   = CNTXT_.user.ws_token;
    data.app_id     = getApplicationId();

    if (localStorage.getItem(STR_SHOW_STATUS) === 'true')
        data.show_status = 1;
    else
        data.show_status = 0;

    wsSend(data);
}
function wsSendData(data){
    if (!wsVars.auth_user) return;
    data.user_id    = CNTXT_.user.id;
    data.ws_token   = userVars.ws_token;
    data.app_id     = getApplicationId();
    wsSend(data);
}
function wsSend(data) {
    data = JSON.stringify(data);
    try{wsVars.socket.send(data);}
    catch (e){}
}
function wsSendMsgStatus(sender_id, discus_id, status_msg) {
    var data = {act: ACT_CONFIRM_DELIVER_MSG};
    data.consumer_id = sender_id;
    data.discus_id   = discus_id;
    data.status_msg  = status_msg;
    wsSendData(data);
}
function wsSendPrintMsgProcess() {
    var data = {act: ACT_PRINT_MSG_PROCESS};
    if (localStorage.getItem(STR_PRINT_TEXT) !== 'true')return;

    data.consumer_id = discusVars.speaker.id;
    data.discus_id   = discusVars.discus.id;
    wsSendData(data);
}
function wsSendGetOnlineStatus(idList) {
    var data = {act: ACT_GET_ONLINE_STATUS};
    data.id_list = idList;
    if(wsVars.state === C_OPEN)wsSendData(data);
}



