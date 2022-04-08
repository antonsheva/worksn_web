function recoveryPass(data) {
    if(!ACheckEmail(data.email)){
        data.act = 'recovery_password';
        APost(data, ACbRecoveryPass);
    }
}

function ACbRecoveryPass(data) {
    var result = Number.parseInt(data.result);
    var msg = q.response;
    if(result === 1){
        APopUpMessage(data.data,0);
     }else{
        APopUpMessage(data.data,1);
    }
}