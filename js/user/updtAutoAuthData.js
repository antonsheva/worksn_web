function updtAutoAuthData(data) {
    data.img = G_tmp_img;
    data.act = 'updt_auto_auth_data';
    if(!data.name)data.name = data.login;
    if(ACheckDataFields(data, 1))return;
    APost(data, ACbUpdtAutoAuthData);
}
function ACbUpdtAutoAuthData(data){
    var error = Number.parseInt(data.error);
    var msg = q.data;
    var tm = msg.length*50;
    if(error === 0){
        APopUpMessage(msg,0);
        // setTimeout(function () {
        //     $(location).attr('href','/');
        // }, 2000);
    }else{
        APopUpMessage(msg,1);
    }
}