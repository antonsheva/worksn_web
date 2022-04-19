function subMenuRemove() {
    $('.subMenu').css('display', 'none');
    switch (G_tmp_obj.type){
        case 'adsCard'  :
            G_tmp_obj.cbFunc      = cbRemoveAds;
            G_tmp_obj.act         = 'rmv_ads';
          
            break;
        case 'msgChain' :
            G_tmp_obj.act         = 'rmv_msg';
            G_tmp_obj.cbFunc      = cbRmvMsg;
            break;
        case 'msgGroup' :
            G_tmp_obj.act         = 'rmv_discus';
            G_tmp_obj.cbFunc      = cbRmvMsg;
            G_tmp_obj.confirm_msg = 'Удалить диалог?'
            break;
        case 'imgGroup' :
            G_tmp_obj.act         = 'rm_tmp_file';
            G_tmp_obj.cbFunc      = ACbRmvGroupImg;
            break;
    }
    data = {};
    data.act =   G_tmp_obj.act;
    data.id  =  G_tmp_obj.id
    data.filename = G_tmp_obj.filename;
    if(G_tmp_obj.confirm_msg){
        G_tmp_obj.confirm_msg = null;
        if(confirm( G_tmp_obj.confirm_msg )) {

            APost(data, G_tmp_obj.cbFunc);
        }
    }else APost(data, G_tmp_obj.cbFunc);
}
function subMenuRecoveryAds() {
    subMenuHidden();
    var data = {};
    data.act = 'recovery_ads';
    data.id = G_tmp_obj.id;
    APost(data, cbRecoveryAds);
}
function subMenuHiddenAds() {
    subMenuHidden();
    var data = {};
    data.act = 'hidden_ads';
    data.id = G_tmp_obj.id;
    APost(data, cbHiddenAds);
}
function subMenuShowAds() {
    subMenuHidden();
    var data = {};
    data.act = 'show_ads';
    data.id = G_tmp_obj.id;
    APost(data, cbShowAds);
}
function subMenuEditAds() {
    subMenuHidden();
    editAds();
}

function subMenuCopy() {
    containerid = G_tmp_obj.target_id+'_copy';
    if (document.selection) { // IE
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select();
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById(containerid));
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
    if(render.subMenuVisible){
        G_event.click = C_DESABLE;
        render.subMenuVisible = false;
    }
    $('.subMenu').css('display', 'none');
}
function showSubMenu(){
    $('.subMenu .copy').css('display', 'none');
    $('.subMenu .reply').css('display', 'none');
    $('.subMenu .remove').css('display', 'none');
    $('.subMenu .recovery').css('display', 'none');
    $('.subMenu .hidden').css('display', 'none');
    $('.subMenu .show').css('display', 'none');
    $('.subMenu .edit').css('display', 'none');


    if(G_tmp_obj.type === 'imgGroup'){
        $('.subMenu .remove').css('display', 'block');
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
        if (ads.remove == 1){
            $('.subMenu .recovery').css('display', 'block');
        }else if (ads.active != 1){
            $('.subMenu .remove').css('display', 'block');
            $('.subMenu .show').css('display', 'block');
        }else {
            $('.subMenu .remove').css('display', 'block');
            $('.subMenu .hidden').css('display', 'block');
        }
    }

    if(G_event.timer===C_DESABLE)return;
    G_event.click = C_DESABLE;
    render.subMenuVisible = true;
    leftShit = parseInt($('.subMenu').css('width'));
    if(G_mouseX > 250)G_mouseX = (G_mouseX-leftShit-30);
    else              G_mouseX += 30;
    $('.subMenu').css('top', G_mouseY);
    $('.subMenu').css('left', G_mouseX);
    $('.subMenu').css('display', 'block');
}