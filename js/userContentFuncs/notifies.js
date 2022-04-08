function getNewNotifies() {
    data = {};
    data.act = ACT_GET_NEW_NOTIFY;
    APost(data, cbGetNewNotify);
}
function cbGetNewNotify(data) {
    var notifies = data.context.notifies;
    if (notifies.length>0){
        showSystemNotify(notifies, 'Новые уведомления:');
    }

}
function checkNewNotify() {
    data = {};
    data.act = ACT_CHECK_NEW_NOTIFY;
    APost(data, cbCheckNewNotify);
}
function cbCheckNewNotify(data) {
    var result = parseInt(data.result);
    setNewNotifySign(result);
}
function getAllNotifies() {
    data = {};
    data.act = ACT_GET_ALL_NOTIFY;
    APost(data, cbGetAllNotifies);
}
function cbGetAllNotifies(data) {
    var notifies = data.context.notifies;
    showSystemNotify(notifies, 'Уведомления');
}