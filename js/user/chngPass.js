function AShowNewPass() {
    $('#chngPass .visible').css('display','block');
    $('#chngPass .bt_visible').css('display','none');
}
function chngPass(data) {
    if(!data.password || !data.new_pass || !data.rpt_pass){
        APopUpMessage('Введите необходимые данные', 1);
        return;
    }

    if(data.new_pass !== data.rpt_pass){
        APopUpMessage('Пароли не совпадают', 1);
        return;
    }

    data.act   = 'chng_password';
    data.login = G_cntxt.user.login;

    APost(data,ACbChngPassword)
}

function ACbChngPassword(data) {
    var error  = Number.parseInt(data.error);
    var result = Number.parseInt(data.result);
    var msg = data.data;
    if(error === 0){
        if(result === 1){
            APopUpMessage(msg,0);
            $('#chngPass .visible').css('display','none');
            $('#chngPass .bt_visible').css('display','block');
        }else {
            APopUpMessage(msg,1);
        }
    }else{
        APopUpMessage(msg,1);
    }
}