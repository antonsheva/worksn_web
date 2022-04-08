$(function () {
    $('#frmUsers').on('click', '.frmUserProfile', function (e) {
        if(eventDisable())return;
        user = {};
        user.id  = $(this).attr('data-id');
        user.img = $(this).attr('data-img');
        user.login = $(this).attr('data-login');
        selUserAds(user);
    });
    $('#map').on('click', '.balloonRmvAds', function () {
        // var id = $("#balloonDiscusCard .ads_id").attr('data-id');
        var id = $('#balloonDiscusCard').children('[name=ads_id]').data('id');

        G_tmp_obj.id = id;
        rmvAds(id);
    });
    $('#frmCategory').on('click', '.val', function (e) {
        var catNumber = $(this).attr('data-num');
        selCat(catNumber, true);
    });
    $('#frmLifetime').on('click', '.val', function (e) {
        var val = $(this).attr('data-val');
        var name   = $(this).attr('data-name');
        setLifetime(val, name);
    })
    $('#settingPageContent').on('click', '.content', function (e) {
        var state = $(this).data('state');

        if(state === 'close'){
            $(this).find('img').attr('src','/service_img/design/submenuOpen.gif')
            $(this).find('.description').css('display', 'block');
            $(this).data('state', 'open');

        }else {
            $(this).find('img').attr('src','/service_img/design/submenu.gif')
            $(this).find('.description').css('display', 'none');
            $(this).data('state', 'close');
        }
    })

});
function eventDisable() {
    if(G_event.click === C_DESABLE){
        G_event.click = C_ENABLE;
        return true;
    }else{
        G_event.timer = C_DESABLE;
        return false;
    }
}




