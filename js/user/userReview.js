function sendUserReviewTxt(data) {
    data.act         = 'add_user_review';
    data.sender_id   = CNTXT_.user.id;
    data.owner_id = CNTXT_.owner.id;
    if(!data.sender_id){APopUpMessage('Войдите или зарегистрируйтесь',1);return;}
    APost(data, ACbUserReview);
}
function ACbUserReview(data){
    rvw = frmUserReview(CNTXT_.review);
    $('.removePreviousComment').remove();
    $('#userReviewsField').prepend(rvw);
}
function userVote(star_qt) {
    data = {};
    data.act = 'add_user_review';
    data.star_qt = star_qt;
    data.sender_id   = CNTXT_.user.id;
    data.owner_id = CNTXT_.owner.id;
    if(!data.sender_id){APopUpMessage('Войдите или зарегистрируйтесь',1);return;}
    highlightStars(star_qt);
    APost(data, cbUserVote);
}
function cbUserVote(data) {
    $('#userProfile .slider').css('width', (CNTXT_.float_data/5)+'%');
    $('#userProfile .vote_qt').text('голосов '+CNTXT_.integer_data);//+
}
function printUserReview(arr) {
    for(key in arr){
        if(arr[key].comment){
            data = frmUserReview(arr[key])
            $('#userReviewsField').append(data);
        }
    }
}
function switchBan() {
    if(!G_cntxt.user.id){APopUpMessage('Войдите или зарегистрируйтесь',1);return;}
    data = {};
    data.act = ACT_SET_BW_STATUS;
    data.status = (userProfileVars.bw_status == BW_STATUS_BAN) ? BW_STATUS_EMPTY : BW_STATUS_BAN;
    data.subject_id = userProfileVars.user.id;
    APost(data, cbBwStatus);
}
function switchLike() {
    if(!G_cntxt.user.id){APopUpMessage('Войдите или зарегистрируйтесь',1);return;}
    data = {};
    data.act = 'set_bw_status';
    data.status = (userProfileVars.bw_status == BW_STATUS_LIKE) ? BW_STATUS_EMPTY : BW_STATUS_LIKE;
    data.subject_id = userProfileVars.user.id;
    APost(data, cbBwStatus);
}
function cbBwStatus(data) {
    initBwList(data.context);
    initBwStatus(G_cntxt.banList, G_cntxt.likeList, userProfileVars.user.id);
}
function initBwStatus(banList, likeList, subjectId) {


    if(banList){
        if (banList.indexOf(subjectId) > -1)
            $('.ban').attr('src',"/service_img/design/ban.png");
        else
            $('.ban').attr('src',"/service_img/design/no_ban.png");
    }
    if (likeList){
        if (likeList.indexOf(subjectId) > -1)
            $('.like').attr('src','/service_img/design/choose.png');
        else
            $('.like').attr('src','/service_img/design/no_choose.png');
    }
}
function initBwList(data) {
    if (data.ban_list)
        G_cntxt.banList = data.ban_list.split('_');
    else
        G_cntxt.banList = [];

    if (data.like_list)
        G_cntxt.likeList = data.like_list.split('_');
    else
        G_cntxt.likeList = [];

    if(userProfileVars.user){
        if (G_cntxt.banList.indexOf(userProfileVars.user.id) > -1)
            userProfileVars.bw_status = BW_STATUS_BAN;
        else if (G_cntxt.likeList.indexOf(userProfileVars.user.id) > -1)
            userProfileVars.bw_status = BW_STATUS_LIKE;
        else
            userProfileVars.bw_status = BW_STATUS_EMPTY;
    }
}
function initUserProfile() {
    userProfileVars.user = CNTXT_.owner;
    userVars.targetUsers.push(userProfileVars.user.id)
    initBwList(G_cntxt.user);
    fillOwnerData();
    initBwStatus(G_cntxt.banList, G_cntxt.likeList, userProfileVars.user.id);
    var arr = CNTXT_.user_reviews;
    printUserReview(arr);
    wsCheckOwnerStatus();
    G_imgType = C_IMG_AVATAR;
}
function showBigAvatar() {
    G_event.click = C_ENABLE;
    var img = BASE_URL+userProfileVars.user.img;
    zoomImg(img);
}
function showDiscusesWithUser() {
    if(!G_cntxt.user.id){APopUpMessage('Войдите или зарегистрируйтесь',1);return;}
    localStorage.setItem('mode', MODE_DISCUS_WITH_USER);
    localStorage.setItem('user_id', userProfileVars.user.id);
    location.href = '/';
}
function fillOwnerData() {
    $('#userProfile .name')      .text(CNTXT_.owner.name);
    $('#userProfile .s_name')    .text(CNTXT_.owner.s_name);
    $('#userProfile .phone')     .text(CNTXT_.owner.phone);
    $('#userProfile .email')     .text(CNTXT_.owner.email);

    $('#userProfile .create_date')     .text(CNTXT_.owner.create_date);
    $('#userProfile .last_time ')     .text('заходил '+CNTXT_.owner.last_time );

    $('#userProfile .about_user').text(CNTXT_.owner.about_user);
    $('#userProfile .txt_review').text(CNTXT_.review.comment);
    $('#userProfile .vote_qt').text(CNTXT_.owner.vote_qt);//
    $('#userProfile .slider').css('width', (CNTXT_.owner.rating/5)+'%');
    highlightStars(CNTXT_.review.star_qt);
    if(CNTXT_.user.id){
        $('.txt_review').attr('placeholder','Тут Вы можете оставить отзыв о данном пользователе');
        $('.txt_review').attr('disabled', null);
    }
    else{
        $('.txt_review').attr('placeholder','Чтобы оставить отзыв необходимо войти в аккаунт');
        $('.txt_review').attr('disabled', 'disabled');
    }
}