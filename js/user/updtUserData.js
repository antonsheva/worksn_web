function updtUserData(data) {
    if (data.email === G_cntxt.user.email)
       delete data.email;

    if (G_tmp_img)
        data.img   = G_tmp_img;

    data.act   = ACT_UPDATE_USER_DATA;
    data.login = G_cntxt.user.login;
    if (data.email)
        if(ACheckEmail(data.email))return;

    APost(data, ACbUpdtUserData);
}
function ACbUpdtUserData(data){
    var error = Number.parseInt(data.error);
    var msg = data.data;
    if(error === 0){
        APopUpMessage(msg,0);
    }else{
        APopUpMessage(msg,1);
    }
}


