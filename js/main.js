function AStart(){
    CNTXT_ = G_cntxt;
    G_mode = G_cntxt.mode;
    if(CNTXT_.user.id != null){
        userVars.ws_token = CNTXT_.user.ws_token;
    }
    setScreenHeights();
    initG();
    initMode();
    switch (CNTXT_.page_name) {
        case 'home'        : AScript_home();break;
        case 'my_profile'  : AScript_my_profile();break;
        case 'user_profile': AScript_user_profile();break;
        case 'registration': AScript_registration();break;
        case 'recovery'    : AScript_recovery();break;
        case 'setting'     : scriptSetting(); break;
    }
}

function initMode() {
    var mode = localStorage.getItem('mode');
    if (mode === null){
        mode = MODE_MAIN;
        localStorage.setItem('mode', mode);
    }
}
function getApplicationId() {
    var appId = localStorage.getItem('app_id');
    if(appId === null){
        rand = Math.random();
        time = G_cntxt.nSecTime;
        appId = time.toString().substr(10) + rand.toString().substr(10);
        localStorage.setItem('app_id', appId);
    }
    return appId;
}
function checkFirsEntry() {
    var isFirstEntry = localStorage.getItem('first_entry');
    if (!isFirstEntry){
        localStorage.clear('first_entry');
        renderFirstEntry();
        setTimeout(function () {
            blinkText("#firstEntry h2", 9, 600, function () {
                setTimeout(function () {
                    renderScreenAdsList();
                }, 3000);
            });
        }, 500);
    }
}


