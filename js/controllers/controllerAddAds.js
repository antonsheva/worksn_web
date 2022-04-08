$(function () {
    $('#addAdsForm .str2 select').on('change', function (e) {
        adsVars.hourStart = $('.tmHourStart').val();
        adsVars.hourStop  = $('.tmHourStop') .val();
        adsVars.minStart  = $('.tmMinStart') .val();
        adsVars.minStop   = $('.tmMinStop')  .val();

        adsVars.error = 0;
        if (adsVars.hourStart === adsVars.hourStop){
            if (adsVars.minStart > adsVars.minStop){
                adsVars.error = ADD_ADS_ERR_TIME_RANGE;
            }
        }
        if (adsVars.error){

            $('.tmHourStart').css('background-color', 'yellow');
            $('.tmHourStop') .css('background-color', 'yellow');
            $('.tmMinStart') .css('background-color', 'yellow');
            $('.tmMinStop')  .css('background-color', 'yellow');
        }else {

            $('.tmHourStart').css('background-color', 'azure');
            $('.tmHourStop') .css('background-color', 'azure');
            $('.tmMinStart') .css('background-color', 'azure');
            $('.tmMinStop')  .css('background-color', 'azure');
        }
    });

})
function cancelAddAdsMode() {
    G_globalMode = C_MODE_MAIN;
    renderScreenAdsList();
    highlightTabAdsParam();
    $('.sendingImgs ').empty();
    G_.img_cnt = 0;
    removeTmpImgs();
    adsVars.editFlag = false;
}

