function AScript_home() {
    G_imgType = C_IMG_MSG;
    mapVars.coords = [null, null];
    getEnvironmentData();
    initWsMonitor();
    checkNewNotify();

    adsParameterReset();
    initHomePage();
    ymaps.ready(function (e) {
        MapInit();
        setCenterToMyLocation(null);
    });
    if(CNTXT_.user.id){
        checkNewMsg();
    }

}

function AScript_my_profile() {
    fillUserData();
    G_imgType = C_IMG_AVATAR;
}
function AScript_user_profile() {
    initWsMonitor();
    initUserProfile()
}
function AScript_registration() {
    getSettingPageData();
}
function AScript_recovery() {

}
function scriptSetting() {
    initCheckBoxes();
    getSettingPageData();
    getNewNotifies();
}



//--------------------------------------------


function initHomePage() {
    initBwList(G_cntxt.user);
    switch( parseInt(localStorage.getItem('mode'))){
        case MODE_MAIN :
            renderScreenAdsList();

            mapVars.noBoundsChange = false;
            // setTimeout(function () {
            //     checkFirsEntry();
            // }, 2000);
            break;
        case MODE_DISCUS_WITH_USER :
            renderScreenMsgGroupList();
            getDiscusWithUser(localStorage.getItem('user_id'));
            render.noChangeScreen = true;
            break;
    }
}
function initWsMonitor() {
    if(G_.user.id != null){
        initSocket();
    }
    setInterval(wsCheckSocketConnection, 3000);
}
function initCheckBoxes() {
    if (!localStorage.getItem(SHOW_STATUS))
        localStorage.setItem(SHOW_STATUS, 'true');
    if (!localStorage.getItem(DELIVER_MSG))
        localStorage.setItem(DELIVER_MSG, 'true');
    if (!localStorage.getItem(VIEW_MSG))
        localStorage.setItem(VIEW_MSG, 'true');
    if (!localStorage.getItem(PRINT_TEXT))
        localStorage.setItem(PRINT_TEXT, 'true');


    if (localStorage.getItem(VIEW_MSG) === 'true')
        $('.checkViewMsg').prop('checked', true);
    else  $('.checkViewMsg').prop('checked', false);

    if (localStorage.getItem(PRINT_TEXT) === 'true')
        $('.checkPrintText').prop('checked', true);
    else  $('.checkPrintText').prop('checked', false);

    for(var i=0; i<localStorage.length; i++) {
        var key = localStorage.key(i);

    }

    if (localStorage.getItem(DELIVER_MSG) === 'true')
        $('.checkDeliverMsg').prop('checked', true);
    else
        $('.checkDeliverMsg').prop('checked', false);

    if (localStorage.getItem(SHOW_STATUS) === 'true'){
        $('.checkShowStatus').prop('checked', true);
    }else  {
        $('.checkShowStatus').prop('checked', false);
    }
}

function clickCheckShowStatus() {
    if ($('.checkShowStatus').is(':checked')){
        localStorage.setItem(SHOW_STATUS, 'true');

    }else{
        localStorage.setItem(SHOW_STATUS, 'false');
        localStorage.setItem(DELIVER_MSG, 'false');
        $('.checkDeliverMsg').prop('checked', false);
        localStorage.setItem(VIEW_MSG, 'false');
        $('.checkViewMsg').prop('checked', false);
        localStorage.setItem(PRINT_TEXT, 'false');
        $('.checkPrintText').prop('checked', false);
    }
}
function clickCheckDeliverMsg() {
    if ($('.checkDeliverMsg').is(':checked'))
        localStorage.setItem(DELIVER_MSG, 'true');
    else
        localStorage.setItem(DELIVER_MSG, 'false');
}
function clickCheckViewMsg() {
    if ($('.checkViewMsg').is(':checked'))
        localStorage.setItem(VIEW_MSG, 'true');
    else
        localStorage.setItem(VIEW_MSG, 'false');
}
function clickCheckPrintText() {
    if ($('.checkPrintText').is(':checked'))
        localStorage.setItem(PRINT_TEXT, 'true');
    else
        localStorage.setItem(PRINT_TEXT, 'false');
}
function getEnvironmentData() {
    data = {};
    data.act = 'get_env_data';
    APost(data, cbGetEnvData);
}
function getSettingPageData() {
    data = {};
    data.act = 'get_setting_data';
    APost(data, cbGetSettingPageData);
}
function cbGetEnvData(data) {
    var d = data.context;
    $.each(d.categories, function (index, item) {
        envVars.catList[item.pos] = item.name;
    })
    $.each(d.lifetime, function (index, item) {
        var data = {};
        data.pos  =  item.pos;
        data.name =  item.name;
        data.val  =  item.val;
        envVars.lifetimeList[item.pos] = data;

    })
    envVars.catList[100] = 'Переписка с администратором';
    envVars.catList[101] = 'Переписка с пользователем';
    renderEnvironmentData(data.context);
}
function cbGetSettingPageData(data) {
    dList = CNTXT_.setting_page_data;
    createSettingPageDynamicContent(dList);
}

