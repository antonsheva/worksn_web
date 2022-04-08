tmOut = null;
function frmWriteMsgProcess() {
    cnt = 0;
    $('#frmSendMsgForm .printMsgProcessFrame').css('visibility', 'visible');
    intrvl = setInterval(function () {
        switch (cnt & 3){
            case 0 : $('#frmSendMsgForm .printMsgProcessFrame').text('Печатает');    break;
            case 1 : $('#frmSendMsgForm .printMsgProcessFrame').text('Печатает.');    break;
            case 2 : $('#frmSendMsgForm .printMsgProcessFrame').text('Печатает..');    break;
            case 3 : $('#frmSendMsgForm .printMsgProcessFrame').text('Печатает...');    break;
        }
        cnt++;
    }, 300);
    if(tmOut){
        clearTimeout(tmOut);
        tmOut = null;
    }
    tmOut = setTimeout(function () {
        $('#frmSendMsgForm .printMsgProcessFrame').css('visibility', 'hidden');
        clearInterval(intrvl);
    }, 5000)

}