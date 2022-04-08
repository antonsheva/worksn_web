function printMessagesGroup(msgs) {
    msgVars.messages = [];
    $('#msgWindow .appendData').empty();
    $.each($(msgs).get().reverse(), function (index, item) {
        if(!item.sender_img || (item.sender_img==''))item.sender_img = "wksn_users_img/avatars/f1/no-avatar.jpg";
        $('#msgWindow .appendData').prepend(frmMsgGroup(item));
    })
    // setHeightDiscusFrame();
    $('#msgWindow .appendData').scrollTop($('#msgWindow .appendData').prop('scrollHeight'));
}
function printMessagesChain(msgs) {
    $('.messagesFrame').empty();
    $.each($(msgs).get().reverse(), function (index, item) {
        $('.messagesFrame').append(frmMsgChain(item));
    });
    $('.messagesFrame').scrollTop($('.messagesFrame')[0].scrollHeight);
}
function printAdsCollection(data) {
    adsVars.adsList = [];
    $('#frmVisibleAds .appendData').empty();
    $.each(data, function (index, item) {
        if(item) {
            $('#frmVisibleAds .appendData').prepend(frmAdsCard(item));
        }
    })
}
function printUsersList(data, ext, href) {
    $('#frmUsers').empty();
    users = {};
    if (!data)return;
    $.each(data, function (key, item) {
        if (ext)users[item.user_id] = item;
        else    users[item.id]      = item;
    })
    userVars.targetUsers = [];
    $.each(users, function (key, item) {
        user = {};
        user.id       = ext ? item.user_id       : item.id         ;
        user.login    = ext ? item.user_login    : item.login      ;
        user.rating   = ext ? item.user_rating   : item.rating     ;
        user.img_icon = ext ? item.user_img_icon : item.img_icon   ;
        // $('#frmUsers').append(frmUserIcon(user));
        $('#frmUsers').append(frmUserProfile(user, href));
        if (userVars.targetUsers.indexOf(item.user_id) === -1)
            userVars.targetUsers.push(item.user_id)

    })
    // wsCheckUsersGroupStatus()
}






