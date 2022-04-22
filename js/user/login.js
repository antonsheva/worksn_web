var tmpTimer = null;
function ALogin(par){
    var login    = par.login;
    var password = par.password;
    if(login && password){
        var data = {act:ACT_LOGIN, login:login, password:password};
        APost(data, ACbLogin)
    }else {
        attractAttention($('#loginForm .sendData'));
    }
}

function AAnonymLogin(obj) {
    var data = {act:ACT_ANONYMOUS_LOGIN};
    APost(data, ACbLogin);
}



function ACbLogin(data){
    if(data.result === 1){
        location.reload();
    }
    else APopUpMessage(data.data,1);
}













