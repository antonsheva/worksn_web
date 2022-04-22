function frmUserProfile(user, setHref) {
    user_id     = (user.id !== null) ? user.id : 0;
    user_login  = (user.login !== null) ? user.login : 'login';
    user_rating = (user.rating !== null) ? user.rating : 0;
    user_img    = (user.img_icon !== null) ? user.img_icon : URL_IMG_NO_AVATAR;
    hRef = setHref ? 'href="'+HREF_USER_PROFILE+user_id+'"' : '';
    G_objCounter++;
    var stars =   frmRatingStars(user_rating);
    return ' ' +
        '<div class="frmUserProfile"data-id = "'+user_id+'"' +
        '                           data-login = "'+user_login+'"' +
        '                           data-img = "'+user_img+'">'+
        '     <div style="width: 100%; text-align: center;">' +
        '         <a '+hRef+' style="display: inherit">' +
        '             <div class="menu_login">'+user_login+'</div>' +
        '             <img class="online '+user_id+'" src="'+URL_IMG_ONLINE+'" style="display: none">' +
        '             <object data="/'+user_img+'" class="avatar">' +
        '               <img class="avatar" src="'+URL_IMG_NO_AVATAR+'">' +
        '             </object>' +
        '         </a>' +
        '     </div>'+
              stars+
        '</div>';

}
function frmRatingStars(rating) {
    return'        <div class="frmRatingStars">' +
        '                   <img src="'+URL_IMG_STARS_BAD+'">' +
        '                   <img src="'+URL_IMG_STARS_OK+'" style="width: '+rating/5+'%">' +
        '                   <img src="'+URL_IMG_STARS+'">' +
        '          </div>';
}