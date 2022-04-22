function ASendRegForm(data) {
    data.img = G_tmp_img;
    data.act = ACT_REG_NEW_USER;
    if(!data.name)data.name = data.login;
    if(ACheckDataFields(data, 1))return;
    APost(data, ACbSendRegForm);
}
function ACbSendRegForm(data){
    var error = Number.parseInt(data.error);
    var msg = q.data;
    if(error === 0){
        APopUpMessage(msg,0);
        setTimeout(function () {
            $(location).attr('href','/');
        }, 4000);
    }else{
        APopUpMessage(msg,1);
    }
}

