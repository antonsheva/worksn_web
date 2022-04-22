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

/////////////////////////////////////////////////////

function initHomePage() {
    initBwList(G_cntxt.user);
    switch( parseInt(localStorage.getItem(STR_MODE))){
        case MODE_MAIN :
            renderScreenAdsList();
            mapVars.noBoundsChange = false;
            break;
        case MODE_DISCUS_WITH_USER :
            renderScreenMsgGroupList();
            getDiscusWithUser(localStorage.getItem(STR_USER_ID));
            renderVars.noChangeScreen = true;
            break;
    }
}
function initWsMonitor() {
    if(G_.user.id){
        initSocket();
    }
    setInterval(wsCheckSocketConnection, 3000);
}
function initCheckBoxes() {
    if (!localStorage.getItem(STR_SHOW_STATUS))
        localStorage.setItem(STR_SHOW_STATUS, 'true');
    if (!localStorage.getItem(STR_DELIVER_MSG))
        localStorage.setItem(STR_DELIVER_MSG, 'true');
    if (!localStorage.getItem(STR_VIEW_MSG))
        localStorage.setItem(STR_VIEW_MSG, 'true');
    if (!localStorage.getItem(STR_PRINT_TEXT))
        localStorage.setItem(STR_PRINT_TEXT, 'true');


    if (localStorage.getItem(STR_VIEW_MSG) === 'true')
        $('.checkViewMsg').prop('checked', true);
    else  $('.checkViewMsg').prop('checked', false);

    if (localStorage.getItem(STR_PRINT_TEXT) === 'true')
        $('.checkPrintText').prop('checked', true);
    else  $('.checkPrintText').prop('checked', false);

    for(var i=0; i<localStorage.length; i++) {
        var key = localStorage.key(i);

    }

    if (localStorage.getItem(STR_DELIVER_MSG) === 'true')
        $('.checkDeliverMsg').prop('checked', true);
    else
        $('.checkDeliverMsg').prop('checked', false);

    if (localStorage.getItem(STR_SHOW_STATUS) === 'true'){
        $('.checkShowStatus').prop('checked', true);
    }else  {
        $('.checkShowStatus').prop('checked', false);
    }
}

function clickCheckShowStatus() {
    if ($('.checkShowStatus').is(':checked')){
        localStorage.setItem(STR_SHOW_STATUS, 'true');

    }else{
        localStorage.setItem(STR_SHOW_STATUS, 'false');
        localStorage.setItem(STR_DELIVER_MSG, 'false');
        $('.checkDeliverMsg').prop('checked', false);
        localStorage.setItem(STR_VIEW_MSG, 'false');
        $('.checkViewMsg').prop('checked', false);
        localStorage.setItem(STR_PRINT_TEXT, 'false');
        $('.checkPrintText').prop('checked', false);
    }
}
function clickCheckDeliverMsg() {
    if ($('.checkDeliverMsg').is(':checked'))
        localStorage.setItem(STR_DELIVER_MSG, 'true');
    else
        localStorage.setItem(STR_DELIVER_MSG, 'false');
}
function clickCheckViewMsg() {
    if ($('.checkViewMsg').is(':checked'))
        localStorage.setItem(STR_VIEW_MSG, 'true');
    else
        localStorage.setItem(STR_VIEW_MSG, 'false');
}
function clickCheckPrintText() {
    if ($('.checkPrintText').is(':checked'))
        localStorage.setItem(STR_PRINT_TEXT, 'true');
    else
        localStorage.setItem(STR_PRINT_TEXT, 'false');
}
function getEnvironmentData() {
    data = {};
    data.act = ACT_GET_ENVIRONMENT_DATA;
    APost(data, cbGetEnvData);
}
function getSettingPageData() {
    data = {};
    data.act = ACT_GET_SETTING_DATA;
    APost(data, cbGetSettingPageData);
}
function cbGetEnvData(data) {
    var d = data.context;
    $.each(d.categories, function (index, item) {
        envVars.catList[item.pos] = item.name;
    });
    $.each(d.lifetime, function (index, item) {
        var data = {};
        data.pos  =  item.pos;
        data.name =  item.name;
        data.val  =  item.val;
        envVars.lifetimeList[item.pos] = data;

    });
    envVars.catList[100] = STRING_DISCUS_WITH_ADMIN;
    envVars.catList[101] = STRING_DISCUS_WITH_USER;
    renderEnvironmentData(data.context);
}
function cbGetSettingPageData(data) {
    dList = CNTXT_.setting_page_data;
    createSettingPageDynamicContent(dList);
}

