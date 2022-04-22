controllerBalloonTimer = null;
$(function () {
    var tm1 = null;
    var obj = null;
    if ('ontouchstart' in window) {
        $('#map').on('touchstart','#balloonDiscusCard',function (e) {
            balloonDiscusCardSubMenu(this, e);
        }).on('click touchend','#balloonDiscusCard', function () {
            controllerBalloonClick(this);
        })
    }else {
        $('#map').on('mousedown','#balloonDiscusCard',function (e) {
            balloonDiscusCardSubMenu(this, e);
        }).on('click touchend','#balloonDiscusCard', function () {
            controllerBalloonClick(this);
        })
    }
});
function controllerBalloonClick(obj){
        clearTimeout(controllerBalloonTimer);
        if(eventDisable())return;
        var ads_id      = $(obj).children('[name=ads_id]').data('id');
        var consumer_id = $(obj).children('[name=owner_id]').data('id');
        getDiscusForAds(ads_id, consumer_id);
}

function balloonDiscusCardSubMenu(obj, e) {
    var consumer_id = $(obj).find('[name=owner_id]').data('id');
    var ads_id      = $(obj).find('[name=ads_id]').data('id');

    if(parseInt(G_.user.id) !== parseInt(consumer_id))return;
    fixEventData(obj, e, e.type);
    G_tmp_obj.type        = 'adsCard';
    G_tmp_obj.id          = ads_id;
    G_.target_ads.id      = ads_id;
    console.log('consumer_id -> '+consumer_id)
    console.log('ads_id -> '+ads_id)
    controllerBalloonTimer = setTimeout(showSubMenu, 500);
}


