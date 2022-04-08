function expandMsgToAdmin() {
    if (layoutSetting.expMsgToAdmin){
        $('#layoutSetting .msgToAdminForm').css('display', 'none')
        $('#layoutSetting .msgToAdmin img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expMsgToAdmin = false;
    }else {
        $('#layoutSetting .msgToAdminForm').css('display', 'block')
        $('#layoutSetting .msgToAdmin img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expMsgToAdmin = true;
    }
}
function expandFqAboutRegistration() {
    if (layoutSetting.expFqAboutReg){
        $('.fqAboutRegistration .txt').css('display', 'none');
        $('.fqAboutRegistration img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expFqAboutReg = false;
    }else {
        $('.fqAboutRegistration .txt').css('display', 'block');
        $('.fqAboutRegistration img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expFqAboutReg = true;
    }
}
function expandFqAddAds() {
    if (layoutSetting.expFqAddAds){
        $('.fqAddAds .txt').css('display', 'none');
        $('.fqAddAds img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expFqAddAds = false;
    }else {
        $('.fqAddAds .txt').css('display', 'block');
        $('.fqAddAds img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expFqAddAds = true;
    }
}
function expandFqRemoveAds () {
    if (layoutSetting.expFqRemoveAds){
        $('.fqRemoveAds .txt').css('display', 'none');
        $('.fqRemoveAds img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expFqRemoveAds = false;
    }else {
        $('.fqRemoveAds .txt').css('display', 'block');
        $('.fqRemoveAds img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expFqRemoveAds = true;
    }
}
function expandFqRemoveMsg () {
    if (layoutSetting.expFqRemoveMsg){
        $('.fqRemoveMsg .txt').css('display', 'none');
        $('.fqRemoveMsg img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expFqRemoveMsg = false;
    }else {
        $('.fqRemoveMsg .txt').css('display', 'block');
        $('.fqRemoveMsg img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expFqRemoveMsg = true;
    }
}
function expandFqSecurity () {
    if (layoutSetting.expFqSecurity){
        $('.fqSecurity .txt').css('display', 'none');
        $('.fqSecurity img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expFqSecurity = false;
    }else {
        $('.fqSecurity .txt').css('display', 'block');
        $('.fqSecurity img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expFqSecurity = true;
    }
}
function expandFqAboutProject () {
    if (layoutSetting.expFqAboutProject){
        $('.fqAboutProject .txt').css('display', 'none');
        $('.fqAboutProject img').attr('src','/service_img/design/submenu.gif')
        layoutSetting.expFqAboutProject = false;
    }else {
        $('.fqAboutProject .txt').css('display', 'block');
        $('.fqAboutProject img').attr('src','/service_img/design/submenuOpen.gif')
        layoutSetting.expFqAboutProject = true;
    }
}
function expandSendMsgToAdmin(data){
    discusVars.speaker.id = 1;
    discusVars.ads.id = 1;
    if(!data.content){
        APopUpMessage('Введите текст сообщения',1);
        return;
    }


    sendMsg(data)
    APopUpMessage('Сообщение отправлено. Переписка доступна в сообщениях.');
}

function showSystemNotify(notify, type) {
    var data = ''

    if (notify.length === 0){
        $('#layoutSetting .notifyType').text('Нет уведомлений');
        return;
    }

    $.each(notify,  function (index, val) {
        data += '' +
            '<a style="font-size: smaller">'+val.create_date+'</a>' +
            '<div>' +
                val.content +
            '</div>' +
            '<div class="underLine"></div>';
    })

    notify = decodeEntities(notify);

    $('#layoutSetting .notifyType').text(type);
    $('#layoutSetting .systemNotify').css('display', 'block');
    $('#layoutSetting .systemNotify .notify').html(data);
}
function setNewNotifySign(res) {
    if(res){
        src = '/../service_img/design/setting_notify.png';
        $('#userMenu .setting img').attr('src', src);
    }
}


