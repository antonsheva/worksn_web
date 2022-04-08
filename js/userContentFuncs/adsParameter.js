function choiceAdsCategory() {
    renderScreenSelectCategory();
    if (G_globalMode !== C_MODE_ADD_ADS){
        G_globalMode = C_MODE_MAIN;
        highlightTabAdsParam('.adsParamCategory');
    }
}
function choiceAdsUser() {
    G_globalMode = C_MODE_MAIN;
    if (CLLCT_.user_id !== null)selUserAds(null);
    renderScreenUsersList();
}
function choiceEditAdsAdd(id, obj) {
    refreshImgsPanel();
    $('.tmpImgGroup').empty();
    if(G_globalMode !== C_MODE_ADD_ADS){
        G_globalMode = C_MODE_ADD_ADS;
        G_imgType    = C_IMG_ADS;
        renderScreenAddAds();
    }else{
        addAds(GP('addAdsForm') )
    }
}
function showSelUserIcon(user) {
    $('.adsParamUser .bt1').empty();
    if(user === null){
        $('.adsParamUser .bt1').append('<div>Все пользователи</div>');
        return;
    }
    imgTag = '';
    if((user.img != null) && (user.img !='undefined'))imgTag = '<img src="'+user.img+'" style="width: 40px; height: 40px; border-radius: 50%">';
    data =
        '<table>' +
        '   <tr>' +
        '       <td>' +
                     imgTag+
        '       </td>' +
        '       <td style="color: white;">' +
        user.login +
        '       </td>' +
        '   </tr>' +
        '</table>';
    $('.adsParamUser .bt1').append(data);
}


