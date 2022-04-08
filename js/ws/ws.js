function initSocket() {
        WS_.socket = new WebSocket("wss://worksn.ru:8000");
        WS_.socket.onopen = function () {
            WS_.state = C_OPEN;
        };
        WS_.socket.onerror = function (e) {
            WS_.socket.close();
            wsReset();
        };

        WS_.socket.onclose = function () {
            wsReset();
        };

        WS_.socket.onmessage = function (event) {
            data = $.parseJSON(event.data);
            switch (data.type){

                case ACT_CONFIRM_DELIVER_MSG    : wsRcvConfirmViewedMsg(data);  break;
                case ACT_NEW_MSG                : wsRcvNewMsg(data);            break;
                case ACT_PING                   : wsRcvPing();                  break;
                case ACT_ONLINE_LIST            : wsRcvOnlineUsers(data);    break;
                case ACT_AUTH_USER              : wsRcvAuthUser(data);          break;
                case ACT_EXIT                   : wsRcvExit();                  break;
                case ACT_NEW_AUTH_DATA          : wsRcvNewAuthData();           break;
                case ACT_PRINT_MSG_PROCESS      : wsRcvWriteMsgProcess(data);   break;
                case ACT_BIND_IMG_TO_MSG        : wsRcvBindImgToMsg(data)
            }
        }
}


function wsCheckSocketConnection() {
    if(!WS_.state && (G_.user.id !== null)){
        initSocket();
    }
    if((WS_.state === C_OPEN)&&(!WS_.auth_user)&&(G_.user.id !== null)){
        wsSendAuthUser();
    }
}
function wsReset() {
    WS_.socket     = null;
    WS_.port       = null;
    WS_.address    = null;
    WS_.error      = null;
    WS_.state      = null;
    WS_.auth_user  = null;
}
function wsCheckOwnerStatus() {
    var cnt = 0;
    var t1 = setInterval(function () {
        if(WS_.state === C_OPEN){
            wsSendGetOnlineStatus(CNTXT_.owner.id);
            clearTimeout(t1);
        }
        cnt++;
        if(cnt>10){
            vwUserStatus(0)
            clearTimeout(t1);
        }
    }, 200);
}
function wsCheckUsersGroupStatus() {
    var idList = '';
    if (userVars.targetUsers.length == 0)return;
    $.each(userVars.targetUsers, function (index, item) {
        idList += item + '_';
    })
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
    })

    $.each(userVars.targetUsers, function (index, id) {

            if(G_netStatus.indexOf(id) == -1){
                $('.online'+'.'+id).css('display','none');
            }else{
                $('.last_time').text('сейчас в сети');
                $('.online'+'.'+id).css('display','block');
            }
    })

}
function wsRcvExit() {
    data = {};
    data.act = ACT_EXIT;
    wsSendData(data);
    wsReset();
}
function wsRcvPing() {
    data = {};
    data.act = ACT_PONG;
    data.login = CNTXT_.user.login;
    wsSendData(data);
}
function wsRcvNewAuthData() {
    APopUpMessage('Вход с другого устройства', 1);
    AExit(false);
}
function wsRcvAuthUser(data) {
    WS_.auth_user = 1;
    wsCheckUsersGroupStatus();
}

function wsSendAuthUser() {
    data = {};
    data.act        = ACT_AUTH_USER;
    data.user_id    = CNTXT_.user.id;
    data.user_login = CNTXT_.user.login;
    data.ws_token   = CNTXT_.user.ws_token;
    data.app_id     = getApplicationId();

    if (localStorage.getItem(SHOW_STATUS) === 'true')
        data.show_status = 1;
    else
        data.show_status = 0;

    dt = JSON.stringify(data);

    WS_.socket.send(dt);
}
function wsSendData(data){
    if (!WS_.auth_user) return;
    data.user_id    = CNTXT_.user.id;
    data.ws_token   = userVars.ws_token;
    data.app_id     = getApplicationId();
    data = JSON.stringify(data);
    try{
        WS_.socket.send(data);
    }catch (e){
    }
}
function wsSendEnableShowStatus() {
    data = {};
    data.act = ACT_ENABLE_SHOW_STATUS;
    wsSendData(data);
}
function wsSendDisableShowStatus() {
    data = {};
    data.act = ACT_DISABLE_SHOW_STATUS;
    wsSendData(data);
}
function wsSendMsgStatus(sender_id, discus_id, status_msg) {
    data = {};
    data.act         = ACT_CONFIRM_DELIVER_MSG;
    data.consumer_id = sender_id;
    data.discus_id   = discus_id;
    data.status_msg  = status_msg;
    wsSendData(data);
}
function wsSendPrintMsgProcess() {
    if (localStorage.getItem(PRINT_TEXT) !== 'true')return;

    data = {};
    data.act         = ACT_PRINT_MSG_PROCESS;
    data.consumer_id = discusVars.speaker.id;
    data.discus_id   = discusVars.discus.id;
    wsSendData(data);
}
function wsSendGetOnlineStatus(idList) {
    var data = {};
    data.act = ACT_GET_ONLINE_STATUS;
    data.id_list = idList;
    if(WS_.state === C_OPEN)wsSendData(data);
}



