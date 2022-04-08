function notifyMe() {
    Notification.requestPermission().then(function(result) {


        if(result==='granted')G_notify = true;
        else G_notify = false;
    });
}
function newNotify(body, icon, title) {
    var options = {
        body: body,
        icon: icon
    };
    var n = new Notification(title, options);
}