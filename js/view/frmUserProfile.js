
function frmUserProfile(user, setHref) {
    user_id     = (user.id !== null) ? user.id : 0;
    user_login  = (user.login !== null) ? user.login : 'login';
    user_rating = (user.rating !== null) ? user.rating : 0;
    user_img    = (user.img_icon !== null) ? user.img_icon : "service_img/avatars/no-avatar.jpg";
    hRef = setHref ? 'href="/../user_profile/'+user_id+'"' : '';
    G_objCounter++;
    var stars =   frmRatingStars(user_rating);
    return ' ' +
        '<div class="frmUserProfile"data-id = "'+user_id+'"' +
        '                           data-login = "'+user_login+'"' +
        '                           data-img = "'+user_img+'">'+
        '     <div style="width: 100%; text-align: center;">' +
        '         <a '+hRef+' style="display: inherit">' +
        '             <div class="menu_login">'+user_login+'</div>' +
        '             <img class="online '+user_id+'" src="/service_img/design/online.gif" style="display: none">' +
        '             <object data="/'+user_img+'" class="avatar">' +
        '               <img class="avatar" src="/service_img/avatars/no-avatar.jpg">' +
        '             </object>' +
        '         </a>' +
        '     </div>'+
              stars+
        '</div>';

}

function frmRatingStars(rating) {
    return'        <div class="frmRatingStars">' +
        '                   <img src="/service_img/design/stars_bad_bgrd.gif">' +
        '                   <img src="/service_img/design/stars_ok_bgrd.gif" style="width: '+rating/5+'%">' +
        '                   <img src="/service_img/design/stars.gif">' +
        '          </div>';
}