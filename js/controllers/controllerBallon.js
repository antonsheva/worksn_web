balloonDiscusCard_tm = null;
$(function () {
    var tm1 = null;
    if ('ontouchstart' in window) {
        $('#map').on('touchstart','#balloonDiscusCard',function (e) {
            balloonDiscusCardSubMenu(this, e);
        })
    }else {
        $('#map').on('mousedown','#balloonDiscusCard',function (e) {
            balloonDiscusCardSubMenu(this, e);
        })
    }


    $('#map').on('click touchend', '#balloonDiscusCard', function () {
        clearTimeout(balloonDiscusCard_tm);
        if(eventDisable())return;
        var ads_id      = $(this).children('[name=ads_id]').data('id');
        var consumer_id = $(this).children('[name=owner_id]').data('id');
        getDiscusForAds(ads_id, consumer_id);
    })

})
function balloonDiscusCardSubMenu(obj, e) {
    consumer_id = $('#balloonDiscusCard .consumer_id').val();
    if(G_.user.id !== consumer_id)return;
    fixEventData(obj, e, e.type);
    balloonDiscusCard_tm = setTimeout(showSubMenu, 500)
    G_tmp_obj.type        = 'adsCard';
    G_tmp_obj.id          = $('#balloonDiscusCard .ads_id').val();
    G_.target_ads.id =  G_tmp_obj.id ;
}


