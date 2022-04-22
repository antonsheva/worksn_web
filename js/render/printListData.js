function printMessagesGroup(msgs) {
    msgVars.messages = [];
    $('#msgWindow').find('.appendData').empty();
    $.each($(msgs).get().reverse(), function (index, item) {
        if(!item.sender_img)item.sender_img = URL_IMG_NO_AVATAR;
        $('#msgWindow').find('.appendData').prepend(frmMsgGroup(item));
    });
    $('#msgWindow').find('.appendData').scrollTop($(this).prop('scrollHeight'));
}
function printMessagesChain(msgs) {
    $('.messagesFrame').empty();
    $.each($(msgs).get().reverse(), function (index, item) {
        $('.messagesFrame').append(frmMsgChain(item));
    });
    $('.messagesFrame').scrollTop($(this)[0].scrollHeight);
}
function printAdsCollection(data) {
    adsVars.adsList = [];
    $('#frmVisibleAds').find('.appendData').empty();
    $.each(data, function (index, item) {
        if(item) {
            $('#frmVisibleAds').find('.appendData').prepend(frmAdsCard(item));
        }
    });
}
function printUsersList(data, ext, href) {
    $('#frmUsers').empty();
    users = {};
    if (!data)return;
    $.each(data, function (key, item) {
        if (ext)users[item.user_id] = item;
        else    users[item.id]      = item;
    });
    userVars.targetUsers = [];
    $.each(users, function (key, item) {
        user = {};
        user.id       = ext ? item.user_id       : item.id         ;
        user.login    = ext ? item.user_login    : item.login      ;
        user.rating   = ext ? item.user_rating   : item.rating     ;
        user.img_icon = ext ? item.user_img_icon : item.img_icon   ;
        $('#frmUsers').append(frmUserProfile(user, href));
        if (userVars.targetUsers.indexOf(item.user_id) === -1)
            userVars.targetUsers.push(item.user_id)

    })
}






