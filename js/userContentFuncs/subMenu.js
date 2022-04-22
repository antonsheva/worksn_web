function subMenuRemove() {
    $('.subMenu').css('display', 'none');
    switch (G_tmp_obj.type){
        case 'adsCard'  :
            G_tmp_obj.cbFunc      = cbRemoveAds;
            G_tmp_obj.act         = ACT_ADS_REMOVE;
            break;
        case 'msgChain' :
            G_tmp_obj.act         = ACT_REMOVE_MSG;
            G_tmp_obj.cbFunc      = cbRmvMsg;
            break;
        case 'msgGroup' :
            G_tmp_obj.act         = ACT_REMOVE_DISCUS;
            G_tmp_obj.cbFunc      = cbRmvMsg;
            G_tmp_obj.confirm_msg = STRING_Q_REMOVE_DISCUS;
            break;
        case 'imgGroup' :
            G_tmp_obj.act         = ACT_REMOVE_TMP_FILE;
            G_tmp_obj.cbFunc      = ACbRmvGroupImg;
            break;
    }
    var data = {act: G_tmp_obj.act};
    data.id  =  G_tmp_obj.id;
    data.filename = G_tmp_obj.filename;
    if(G_tmp_obj.confirm_msg){
        G_tmp_obj.confirm_msg = null;
        if(confirm( G_tmp_obj.confirm_msg ))
            APost(data, G_tmp_obj.cbFunc);

    }else APost(data, G_tmp_obj.cbFunc);
}
function subMenuRecoveryAds() {
    subMenuHidden();
    var data = {act: ACT_ADS_RECOVERY};
    data.id = G_tmp_obj.id;
    APost(data, cbRecoveryAds);
}
function subMenuHiddenAds() {
    subMenuHidden();
    var data = {act: ACT_ADS_HIDDEN};
    data.id = G_tmp_obj.id;
    APost(data, cbHiddenAds);
}
function subMenuShowAds() {
    subMenuHidden();
    var data = {act: ACT_ADS_SHOW};
    data.id = G_tmp_obj.id;
    APost(data, cbShowAds);
}
function subMenuEditAds() {
    subMenuHidden();
    editAds();
}

function subMenuCopy() {
    var containerId = G_tmp_obj.target_id+'_copy';
    var range;
    if (document.selection) { // IE
        range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerId));
        range.select();
    } else if (window.getSelection) {
        range = document.createRange();
        range.selectNode(document.getElementById(containerId));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
    }
    document.execCommand('copy');
    subMenuHidden();
    if (window.getSelection) {
        window.getSelection().removeAllRanges();
    } else { // старый IE
        document.selection.empty();
    }
}

function subMenuReply() {
    showReplyToMsgForm();
}

function subMenuHidden() {
    if(renderVars.subMenuVisible){
        G_event.click = C_DISABLE;
        renderVars.subMenuVisible = false;
    }
    $('.subMenu').css('display', 'none');
}
function clearSubMenu() {
    $('.subMenu').find('.copy'    ).css('display', 'none');
    $('.subMenu').find('.reply'   ).css('display', 'none');
    $('.subMenu').find('.remove'  ).css('display', 'none');
    $('.subMenu').find('.recovery').css('display', 'none');
    $('.subMenu').find('.hidden'  ).css('display', 'none');
    $('.subMenu').find('.show'    ).css('display', 'none');
    $('.subMenu').find('.edit'    ).css('display', 'none');
}
function showSubMenu(){
    clearSubMenu();
    if(G_tmp_obj.type === 'imgGroup'){
        $('.subMenu').find('.remove').css('display', 'block');
    }
    if(G_tmp_obj.type === 'msgChain'){
        $('.subMenu .copy').css('display', 'block');
        $('.subMenu .reply').css('display', 'block');
        $('.subMenu .remove').css('display', 'block');
    }
    if(G_tmp_obj.type === 'msgGroup'){
        $('.subMenu .remove').css('display', 'block');
    }
    if(G_tmp_obj.type === 'adsCard') {
        $('.subMenu .edit').css('display', 'block');
        var ads = adsVars.adsList[G_tmp_obj.target_id];
        if (parseInt(ads.remove) === 1){
            $('.subMenu .recovery').css('display', 'block');
        }else if (parseInt(ads.active) !== 1){
            $('.subMenu .remove').css('display', 'block');
            $('.subMenu .show').css('display', 'block');
        }else {
            $('.subMenu .remove').css('display', 'block');
            $('.subMenu .hidden').css('display', 'block');
        }
    }

    if(G_event.timerState === C_DISABLE)return;

    G_event.click         = C_DISABLE;
    renderVars.subMenuVisible = true;
    var leftShit = parseInt($('.subMenu').css('width'));
    if(G_mouseX > 250)G_mouseX = (G_mouseX-leftShit-30);
    else              G_mouseX += 30;

    $('.subMenu').css('top', G_mouseY)
                 .css('left', G_mouseX)
                 .css('display', 'block');

}