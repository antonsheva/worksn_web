function AExit(exit){
    G_globalMode = MODE_MAIN;
    highlightTab(null);
    var date = {act:ACT_EXIT};
    G_.user = null;
    APost(date,ACbExit);
    if(exit){
        var data = {}
        data.act = ACT_EXIT;
        wsSendData(data);
    }
}
function ACbExit() {
    location.href = '/';
}