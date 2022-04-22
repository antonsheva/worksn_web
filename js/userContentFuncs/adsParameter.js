function choiceAdsCategory() {
    renderScreenSelectCategory();
    if (G_globalMode !== MODE_ADD_ADS){
        G_globalMode = MODE_MAIN;
        highlightTabAdsParam('.adsParamCategory');
    }
}
function choiceAdsUser() {
    G_globalMode = MODE_MAIN;
    if (CLLCT_.user_id !== null)selUserAds(null);
    renderScreenUsersList();
}
function choiceEditAdsAdd() {
    refreshImgsPanel();
    $('.tmpImgGroup').empty();
    if(G_globalMode !== MODE_ADD_ADS){
        G_globalMode = MODE_ADD_ADS;
        G_imgType    = C_IMG_ADS;
        renderScreenAddAds();
    }else{
        addAds(GP('addAdsForm') )
    }
}
