function highlightTab(id) {
    $('#myButton').find('td').removeClass('activeColor');
    $(id).addClass('activeColor');
}
function highlightTabAdsParam(id) {
    var sel = id+' .bt1';
    $('#myButton .bt1').removeClass('activeColor');
    $(sel).addClass('activeColor');
}
function unHighlightTab(id) {
    $(id).removeClass('activeColor');
}
function highlightAdsTypeButtons() {

    switch (CLLCT_.ads_type){
        case C_TYPE_WORKER  : $('#adsType .btWorker .bt1').addClass('activeColor');
                              $('#adsType .btEmployer .bt1').removeClass('activeColor');
            break;
        case C_TYPE_EMPLOYER: $('#adsType .btEmployer .bt1').addClass('activeColor');
                              $('#adsType .btWorker .bt1').removeClass('activeColor');
            break;
        default:              $('#adsType .btWorker .bt1').  removeClass('activeColor');
                              $('#adsType .btEmployer .bt1').removeClass('activeColor');
    }
}
function blinkText(id, qt, tm, func) {
    var cnt = 0;
    var stt = false;

    if (!qt)      qt = 5;
    if (!tm)      tm = 400;

    var interval = setInterval(function () {
        if(stt){
            $(id).animate({opacity : "1"}, tm);
        }else {
            $(id).animate({opacity : "0.01"}, tm);
        }
        stt = !stt;
        cnt++;
        if (cnt>5){
            clearInterval(interval);
            func();
        }
    }, 600);
}