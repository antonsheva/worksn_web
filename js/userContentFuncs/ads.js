function addAds(data){
    if(!CNTXT_.user.id){APopUpMessage(STRING_SIGN_IN_OR_UP, 1);return;}
    data.act = ACT_ADS_ADD;
    data.category = parseInt(CLLCT_.category);
    if (!parseInt(data.cost))data.cost = 0;
    if((CLLCT_.ads_type !== C_TYPE_EMPLOYER)&&(CLLCT_.ads_type !== C_TYPE_WORKER)){
        attractAttention($('#adsType'));
        APopUpMessage(STRING_CHOOSE_ADS_TYPE,1);return;
    }
    if((!data.description)||(data.description === '')){APopUpMessage(STRING_ENTER_ADS_TXT,1);return;}

    if((data.category === 0)||(data.category === null)){
        attractAttention($('.adsParamCategory'));
        APopUpMessage(STRING_CHOOSE_CATEGORY,1);return;}
    if (adsVars.error === ADD_ADS_ERR_TIME_RANGE){
        APopUpMessage(STRING_BAD_TIME, 1);
        return;
    }
    if((adsVars.hourStart !== null)&&(adsVars.hourStop !== null)&&(adsVars.minStart !== null)&&(adsVars.minStop !== null)){
        data.hour_start = adsVars.hourStart;
        data.hour_stop  = adsVars.hourStop ;
        data.min_start  = adsVars.minStart ;
        data.min_stop   = adsVars.minStop  ;
    }

    data.ads_type = (CLLCT_.ads_type === C_TYPE_WORKER) ? C_TYPE_EMPLOYER : C_TYPE_WORKER;
    data.active = 1;
    data.lifetime = adsVars.lifetime;
    data.img = checkAdsImgs();

    if (adsVars.editFlag){
        adsVars.editFlag = false;
        data.id = adsVars.targetAds.id;
        data.edit = 1;
        if (adsVars.oldImgs){
            data.old_imgs      = adsVars.oldImgs;
            data.old_imgs_icon = adsVars.oldImgsIcon;
        }
    }

    if(mapVars.targetCoords === null){APopUpMessage(STRING_SET_POINT_ON_MAP,1);return;}
    data.coord_x = mapVars.targetCoords[0];
    data.coord_y = mapVars.targetCoords[1];
    mapVars.coords = [null, null];
    G_globalMode = MODE_MAIN;
    APost(data, cbAddAds);
}

function checkAdsImgs() {
    var img = '';
    var key;
    for(key in G_tmp_imgs)
        if (G_tmp_imgs.hasOwnProperty(key))
            img += G_tmp_imgs[key]+',';

    G_tmp_imgs = null;
    G_tmp_imgs = [];
    $('.tmpImgGroup').empty();
    $('.sendingImgs').empty();
    G_tmp_img = null;
    return img;
}
function searchAds(data) {
    CLLCT_.search_phrase = data.content;
    AGetAdsCollection(null);
    $('#frmSearch').find('.content').val('');
}
function showAdsCollectionOnMap(data) {
    $.each(data, function (index, item) {
        if(item)AShowPlaceMark(item);
    })
}
function adsParameterReset(){
    CLLCT_.ads_type = null;
    CLLCT_.category = 0;
    CLLCT_.remove = 0;
    CLLCT_.user_id  = null;
    CLLCT_.active = 1;
}
function rmvAds(id){
    var data = {};
    if(confirm(STRING_Q_REMOVE_ADS)){
        G_.target_ads.id = id;
        data.act = ACT_ADS_REMOVE;
        data.id = id;
        APost(data, cbRemoveAds);
    }
}
function AGetAdsCollection(dntClr){
    data = {act:ACT_GET_ADS_COLLECTION};
    data.cllct = CLLCT_;
    data.crd = MIN_MAX_CRD_;
    if(!dntClr)AClrPlasemarks();
    APost(data, cbGetAdsCollection);
}
function AReloadAdsCollection() {
    AGetContext(StructContext);
    if(G_ads_timer )clearTimeout(G_ads_timer);
    G_ads_timer = setTimeout(function () {
        if(!G_ev_balloonopen)AGetAdsCollection(1);
        G_ev_balloonopen = null;

        if(G_globalMode === MODE_ADD_ADS)renderScreenAddAds();
        else {
            if(renderVars.noChangeScreen){
                renderVars.noChangeScreen = false;
            }else {
                renderScreenAdsList();
                mapVars.noBoundsChange = false;
            }
        }

    }, 1000);
}

function editAds() {
    mapVars.targetCoords = [];
    adsVars.targetAds = null;
    adsVars.targetAds = adsVars.adsList[G_tmp_obj.target_id];
    
    adsVars.hourStart = adsVars.targetAds.hour_start;
    adsVars.hourStop  = adsVars.targetAds.hour_stop;
    adsVars.minStart  = adsVars.targetAds.min_start;
    adsVars.minStop   = adsVars.targetAds.min_stop;

    if(parseInt(adsVars.targetAds.ads_type) === C_TYPE_WORKER)
        CLLCT_.ads_type = C_TYPE_EMPLOYER;
    else
        CLLCT_.ads_type = C_TYPE_WORKER;

    mapVars.targetCoords[0] = parseFloat(adsVars.targetAds.coord_x);
    mapVars.targetCoords[1] = parseFloat(adsVars.targetAds.coord_y);

    myMapSetRedPoint(mapVars.targetCoords);

    highlightAdsTypeButtons()
    choiceEditAdsAdd();
    adsVars.editFlag = true;
    var catName = envVars.catList[adsVars.targetAds.category];
    CLLCT_.category = adsVars.targetAds.category;
    
    $('.adsParamCategory .bt1 a').text(catName);
    $('#addAdsForm').find('.cost').val(adsVars.targetAds.cost);
    $('#addAdsForm').find('.description').val(adsVars.targetAds.description);
    setActivePeriod();

    var data = {};
    data.act      = ACT_ADS_EDIT;
    data.ads_id   = adsVars.targetAds.id;
    data.img      = adsVars.targetAds.img;
    data.img_icon = adsVars.targetAds.img_icon;

    APost(data, cbEditAds);
}
function setActivePeriod() {
    var index = 0;
    $('.tmHourStart option').prop('selected', false);
    $('.tmHourStop  option').prop('selected', false);
    $('.tmMinStart  option').prop('selected', false);
    $('.tmMinStop   option').prop('selected', false);

    $('.tmHourStart option[value='+adsVars.hourStart+']').prop('selected', true);
    $('.tmHourStop  option[value='+adsVars.hourStop +']').prop('selected', true);
    $('.tmMinStart  option[value='+adsVars.minStart +']').prop('selected', true);
    $('.tmMinStop   option[value='+adsVars.minStop  +']').prop('selected', true);
}
function cbEditAds(data) {

    $('.sendingImgs ').empty();
    G_.img_cnt = 0;
    if (parseInt(data.error) === 0){
        if ((parseInt(data.result) > 0)&&(data.context.img_list)){
            imgVars.tmpImgList = data.context.img_list;
            if(imgVars.tmpImgList.length > 10){
                imgList = imgVars.tmpImgList.split(',')
                $.each(imgList, function (index, img) {
                    if (img)addImgToGroup(PATH_TMP_IMG+img, PATH_TMP_IMG_ICON+img);
                })
            }
        }
    }else {
        APopUpMessage(data.response, 1);
    }
}
function cbRemoveAds(data){
    var error = Number.parseInt(data.error);
    var msg = q.response;
    if(error === 0){
        $('#'+G_tmp_obj.target_id).css('background-color', 'antiquewhite');
        $('#'+G_tmp_obj.target_id+' .description').text(STRING_MSG_WAS_REMOVE);
        adsVars.adsList[G_tmp_obj.target_id].remove = 1;
    }else {
         APopUpMessage(msg,1);
    }
}

function cbRecoveryAds(data) {
    if (parseInt(data.error) === 0){
        $('#'+G_tmp_obj.target_id).css('background-color', 'azure');
        $('#'+G_tmp_obj.target_id+' .description').text(adsVars.adsList[G_tmp_obj.target_id].description);
        adsVars.adsList[G_tmp_obj.target_id].remove = 0;
        adsVars.adsList[G_tmp_obj.target_id].active = 1;
    }else {
        APopUpMessage(data.response, 1)
    }
}
function cbHiddenAds(data) {
    $('#'+G_tmp_obj.target_id).css('background-color', 'beige');
    $('#'+G_tmp_obj.target_id+' .description').text(STRING_MSG_HIDDEN);
    adsVars.adsList[G_tmp_obj.target_id].active = 0;
}
function cbShowAds(data) {
    $('#'+G_tmp_obj.target_id).css('background-color', 'azure');
    $('#'+G_tmp_obj.target_id+' .description').text(adsVars.adsList[G_tmp_obj.target_id].description);
    adsVars.adsList[G_tmp_obj.target_id].active = 1;
}

function cbGetAdsCollection(data){
    myMapCollectionViolet.removeAll();
    adsVars.adsCllct = CNTXT_.ads_collection;
    data = [];
    $.each(adsVars.adsCllct, function (index, item) {
        if (G_cntxt.banList.indexOf(item.user_id) === -1){
            data.push(item);
        }
    });
    showAdsCollectionOnMap(data);
    printAdsCollection(data);
    printUsersList(data, true, false);
    printAdsCollection(data);
    highlightAdsTypeButtons();
    $.each(data, function (index, item) {
        if (userVars.targetUsers.indexOf(item.user_id) === -1)
            userVars.targetUsers.push(item.user_id)

    });
    wsCheckUsersGroupStatus();
}
function cbAddAds(data) {
    var error = Number.parseInt(data.error);
    var msg = q.response;
    if(error === 0){
        imgVars.uploadImgs     = [];
        imgVars.uploadImgsIcon = [];
        $('.sendingImgs').empty();
        highlightTabAdsParam(null);
        selCat(0);
        selAdsType(CLLCT_.ads_type, true);
        AClrPlasemarks(C_RED);
        AShowPlaceMark(CNTXT_.target_ads);
        APopUpMessage(STRING_ADS_WAS_ADD);
        G_globalMode = MODE_MAIN;
        renderScreenAdsList();
    }else{
        APopUpMessage(msg,1);
    }
}

function selAdsType(val, getAds){
    if(CLLCT_.ads_type === val){
        CLLCT_.ads_type = C_TYPE_ANY;
    }else{
        CLLCT_.ads_type = val;
    }
    CLLCT_.remove = 0;
    CLLCT_.search_phrase = null;
    if(getAds)AGetAdsCollection();
    if(G_globalMode === MODE_ADD_ADS)renderScreenAddAds();
    else                             renderScreenAdsList();
    if (G_globalMode !== MODE_ADD_ADS)highlightTab(null);
}
function selCat(catNumber, getAds) {
    var catName   = envVars.catList[catNumber];
    CLLCT_.category = catNumber;
    CLLCT_.remove = 0;
    CLLCT_.search_phrase = null;
    if(getAds)AGetAdsCollection();
    if(G_globalMode === MODE_ADD_ADS)renderScreenAddAds();
    else                             renderScreenAdsList();
    $('.adsParamCategory .bt1 h2').text(catName);
    if(catNumber > 0)
        $('#addAdsForm').find('.description').text(catName);
    else
        $('#addAdsForm').find('.description').text('');

}
function setLifetime(val, name) {
    adsVars.lifetime = val;
    $('#addAdsForm').find('.lifetime').text(name)
    renderScreenAddAds();
}
function selUserAds(user) {
    CLLCT_.user_id = null;
    if (user)CLLCT_.user_id = user.id;
    CLLCT_.remove = 0;
    CLLCT_.ads_type = null;
    CLLCT_.search_phrase = null;
    AGetAdsCollection();
    if(user !== null)
        $('.adsParamUser').find('h2').text(user.login);
    else
        $('.adsParamUser').find('h2').text(STRING_ALL_USERS);

}

