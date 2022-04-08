$(function () {
    var tm = null;

    $('#frmVisibleAds').on('touchstart mousedown','.frmAdsCard',function (e) {
        fixEventData(this,e, e.type);
        tm = setTimeout(function (args) {

            if(G_.user.id ==  owner_id)showSubMenu();
            else {
                if(G_event.timer===C_DESABLE)return;
            }
            G_event.click = C_DESABLE;
            myMapCollectionViolet.removeAll();
            mapVars.coords[0] =  G_tmp_obj.coord_x;
            mapVars.coords[1] =  G_tmp_obj.coord_y;
            var myPm = new ymaps.Placemark(mapVars.coords);
            mapVars.noBoundsChange = true;
            setMapCenter(mapVars.coords);
            AAddPlacemarkToCollection(myPm, C_VIOLET);
        }, 500);

        G_tmp_obj.type        = 'adsCard';
        G_tmp_obj.target_id   = $(this).attr('id');

        G_tmp_obj.id          = adsVars.adsList[G_tmp_obj.target_id].id;
        G_tmp_obj.active      = adsVars.adsList[G_tmp_obj.target_id].active;


        G_tmp_obj.coord_x = adsVars.adsList[G_tmp_obj.target_id].coord_x;
        G_tmp_obj.coord_y = adsVars.adsList[G_tmp_obj.target_id].coord_y;
        owner_id          = adsVars.adsList[G_tmp_obj.target_id].user_id;
    });

    $('#frmVisibleAds').on('touchmove','.frmAdsCard',function (e) {
        clearTimeout(tm);
        G_event.click = C_DESABLE;
    })
    $('#frmVisibleAds').on('click touchend', '.frmAdsCard .discusFrameBody', function (e) {
        clearTimeout(tm);
        if(eventDisable())return;
        var ads_id      = adsVars.adsList[G_tmp_obj.target_id].id;
        var consumer_id = adsVars.adsList[G_tmp_obj.target_id].user_id;
        getDiscusForAds(ads_id, consumer_id);
    });
})
