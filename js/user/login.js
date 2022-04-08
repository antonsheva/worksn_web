var tmpTimer = null;
function ALogin(par){

    var login    = par.login;
    var password = par.password;
    var act      = 'login';
    if(login && password){
        var data = {act:act, login:login, password:password};
        APost(data, ACbLogin)
    }else {
        attractAttention($('#loginForm .sendData'));
    }
}

function AAnonymLogin(obj) {
    var act = 'anonym_login';
    var data = {act:act};
    APost(data, ACbLogin);
}



function ACbLogin(data){

    if(data.result === 1){
        location.reload();
    }
    else APopUpMessage(data.data,1);
}













