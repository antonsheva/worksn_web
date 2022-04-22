function getNewNotifies() {
    var data = {act: ACT_GET_NEW_NOTIFY};
    APost(data, cbGetNewNotify);
}
function cbGetNewNotify(data) {
    var notifies = data.context.notifies;
    if (notifies.length>0)
        showSystemNotify(notifies, STRING_NEW_NOTIFIES);

}
function checkNewNotify() {
    var data = {act: ACT_CHECK_NEW_NOTIFY};
    APost(data, cbCheckNewNotify);
}
function cbCheckNewNotify(data) {
    var result = parseInt(data.result);
    setNewNotifySign(result);
}
function getAllNotifies() {
    var data = {act: ACT_GET_ALL_NOTIFY};
    APost(data, cbGetAllNotifies);
}
function cbGetAllNotifies(data) {
    var notifies = data.context.notifies;
    showSystemNotify(notifies, STRING_NOTIFIES);
}