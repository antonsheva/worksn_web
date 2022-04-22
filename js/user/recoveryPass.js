function recoveryPass(data) {
    if(!ACheckEmail(data.email)){
        data.act = ACT_RECOVERY_PASSWORD;
        APost(data, ACbRecoveryPass);
    }
}
function ACbRecoveryPass(data) {
    var result = Number.parseInt(data.result);
    if(result === 1){
        APopUpMessage(data.data,0);
     }else{
        APopUpMessage(data.data,1);
    }
}