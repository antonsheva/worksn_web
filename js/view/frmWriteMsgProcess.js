function frmWriteMsgProcess() {
    var tmOut = null;
    var cnt = 0;
    $('.printMsgProcessFrame').css('visibility', 'visible');
    intrvl = setInterval(function () {
        switch (cnt & 3){
            case 0 : {$('.printMsgProcessFrame').text(STRING_PRINTS_1);    break;}
            case 1 : {$('.printMsgProcessFrame').text(STRING_PRINTS_2);    break;}
            case 2 : {$('.printMsgProcessFrame').text(STRING_PRINTS_3);    break;}
            case 3 : {$('.printMsgProcessFrame').text(STRING_PRINTS_4);    break;}
        }
        cnt++;
    }, 300);
    if(tmOut){
        clearTimeout(tmOut);
        tmOut = null;
    }
    tmOut = setTimeout(function () {
        $('.printMsgProcessFrame').css('visibility', 'hidden');
        clearInterval(intrvl);
    }, 5000)
}