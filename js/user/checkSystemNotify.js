function checkSystemNotify() {
    notify_id = G_cntxt.user.notify_id;
    old_notify_id = localStorage.getItem('notify_id');
    if (notify_id > 0){
        if(notify_id !== old_notify_id){

            return G_cntxt.user.system_notify;
        }
    }
    return null;
}
 