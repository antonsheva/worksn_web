function setScreenHeights(){
    size = screenSize();
    ht = (size.h * 0.99)+'px';
    $('.mainScreen').css('height', ht);
    if(CNTXT_.user.id === null){
        $('.windowUserMenu').css('height', '10%');
        $('.windowActive').css('height', '29%');
        $('.windowDiscus').css('height', '76%');
    }
    $('.replyToMsgForm').css('bottom', '1px');
}
function resetActiveScreen() {
    $('.adsParamAddAds .bt1').text(STRING_ADD_ADS);
    $('.windowActive > div').css('display', 'none');
}
function renderScreenMain() {
    if(mapVars.noBoundsChange){
        $('.mainScreen .windowMap').css('height', '33%');
        $('.mainScreen .windowMap').css('visibility', 'visible');
        ymaps.ready(function (e) {
            if(myMap)
               myMap.container.fitToViewport();
        });
    }
    $('.mainScreen .windowActive').css('display', 'block');
    $('.mainScreen .windowUserMenu').css('display', 'block');
    $('.mainScreen .windowAdsType').css('display', 'block');
    $('.mainScreen .windowAdsParameter').css('display', 'block');
    $('.mainScreen .activeLabel').css('display', 'block');
    $('.mainScreen .windowSearch').css('display', 'block');
    $('.mainScreen .windowDiscus').css('display', 'none');

    discusVars.discus = {};
}
function renderScreenDiscus() {
    resetDiscusVars();
    mapVars.noBoundsChange = true;
    $('.mainScreen .windowUserMenu').css('display', 'block');
    $('.mainScreen .windowAdsType').css('display', 'block');
    $('.mainScreen .windowMap').css('height', '1px');
    $('.mainScreen .windowMap').css('visibility', 'hidden');
    $('.mainScreen .windowAdsParameter').css('display', 'none');
    $('.mainScreen .activeLabel').css('display', 'none');
    $('.mainScreen .windowActive').css('display', 'none');
    $('.mainScreen .windowSearch').css('display', 'none');
    $('.mainScreen .windowDiscus').css('display', 'block');

}
function renderMessagesScreen(state) {
    if (state)renderVars.msgScreenState = state;
    if(renderVars.msgScreenState){
        $('.windowDiscus  .fullDescription').css('display', 'none');
        $('#frmDiscusCard .shortDescription').css('display', 'block');
        $('.windowDiscus .frmMsg').css('display', 'block');
        $('.messagesFrame').scrollTop($('.messagesFrame')[0].scrollHeight);
        renderVars.msgScreenState = false;
    }else{
        $('.windowDiscus  .fullDescription').css('display', 'block');
        $('#frmDiscusCard .shortDescription').css('display', 'none');
        $('.windowDiscus .frmMsg').css('display', 'none');
        renderVars.msgScreenState = true;
    }
}
function renderScreenMsgChainList(){
    renderScreenDiscus();
    $('.mainScreen .windowDiscus .windowMsgChain').css('display', 'block');
    $('.mainScreen .windowDiscus .windowAdsDescription').css('display', 'none');
}
function renderScreenMsgGroupList() {
    renderScreenMain();
    resetActiveScreen();
    $('.activeLabel').text(STRING_DISCUSES);
    $('.mainScreen .windowActive .msg').css('display', 'block');
}
function renderScreenAdsList() {
    mapVars.noBoundsChange = true;
    renderScreenMain();
    resetActiveScreen();
    $('.activeLabel').text(STRING_ADS_WORKERS_EMPLOYERS);
    $('.mainScreen .windowActive .visibleAds').css('display', 'block');
}
function renderScreenSelectLifetime() {
    renderScreenMain();
    resetActiveScreen();
    $('.mainScreen .windowActive #frmLifetime').css('display', 'block');
}
function renderScreenSelectCategory() {
    if (G_globalMode !== MODE_ADD_ADS)highlightTabAdsParam('.adsParamCategory');
    renderScreenMain();
    resetActiveScreen();
    $('.activeLabel').text(STRING_TO_CHOOSE_CATEGORY);
    $('.mainScreen .windowActive #frmCategory').css('display', 'block');
}
function renderScreenUsersList(title) {
    highlightTabAdsParam('.adsParamUser');
    renderScreenMain();
    resetActiveScreen();
    if (!title)title = STRING_OWNERS_OF_VISIBLE_ADS;
    $('.activeLabel').text(title);
    $('.mainScreen .windowActive .users').css('display', 'block');
}
function renderScreenAddAds() {
    highlightTabAdsParam('.adsParamAddAds');
    renderScreenMain();
    resetActiveScreen();
    $('.adsParamAddAds .bt1').text(STRING_PUBLISH);
    $('.activeLabel').text(STRING_ADD_ADS);
    $('.mainScreen .windowActive .addAds').css('display', 'block');
}
function renderFirstEntry() {
    renderScreenMain();
    resetActiveScreen();
    $('.mainScreen .windowActive .firstEntry').css('display', 'block');
}

function renderRollDiscus() {
    mapVars.noBoundsChange = true;
    imgVars.uploadImgsIcon = [];
    renderScreenAdsList();
}

attractTimer = null;
attractTimerBusy = false;
function attractAttention(obj) {
    if(attractTimerBusy)return;
    attractTimerBusy = true;
    colorsArray = ['#9596ff','#ff6261'];
    pressButton_obj = obj;
    pressButton_color = $(obj).css('background-color')
    cnt=0;
    $(obj).css('background-color', '#9596ff')
    attractTimer = setInterval(function () {
        tmpColor = (cnt%2) ? '#9596ff' : '#ff6261';
        $(obj).css('background-color', tmpColor)
        cnt++;
        if(cnt>3){
            $(pressButton_obj).css('background-color', pressButton_color)
            clearInterval(attractTimer);
            attractTimerBusy = false;
        }
    }, 100);
}
function screenSize() {
    return {
        h : window.innerHeight,
        w : window.innerWidth
    }
}
