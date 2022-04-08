function chngRegData(par) {
    if(G_tmp_img)par['img'] = G_tmp_img;
    par['act'] = act = 'chng_reg_data';
    if(ACheckEmail(par.email))return;


    // APost(data, ACbChngRegData);
}

function ACbChngRegData() {
    var error = Number.parseInt(data.error);
    var msg = q.response;
    if(error === 0){
        APopUpMessage(msg,0);
        setTimeout(function () {
            $(location).attr('href','/');
        }, msg.length*50);
    }else{
        APopUpMessage(msg,1);
    }
}