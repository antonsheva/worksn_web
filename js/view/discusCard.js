function initDiscusCard(owner) {
    var time = (discusVars.ads.create_date) ?
                discusVars.ads.create_date : '--:--';

    var description = (discusVars.ads.description) ?
                       discusVars.ads.description : STRING_SOME_USEFUL;

    var category = (discusVars.ads.category) ?
                    envVars.catList[discusVars.ads.category] : STRING_SERVICE;

    var rating = owner.rating/5+'%';

    var href = HREF_USER_PROFILE+owner.id;
    var cost = ((discusVars.ads.cost)&&(discusVars.ads.cost > 0)) ?
                 discusVars.ads.cost+'p.' : '';

    $('#frmDiscusCard .slider').css('width', rating);
    $('#frmDiscusCard .login').text(owner.login);
    $('#frmDiscusCard .href').attr('href', href);
    $('#frmDiscusCard .time').text(time);
    $('#frmDiscusCard .category').text(category);
    $('#frmDiscusCard .cost').text(cost);
    $('#frmDiscusCard .shortDescription').text(description);
    $('.windowDiscus .fullDescription').text(description);
    $('#frmDiscusCard .profile .online').addClass(owner.id);


    if (urlExists(URL_BASE+owner.img_icon))
        $('#frmDiscusCard .avatar').attr('src',  owner.img_icon);
    else
        $('#frmDiscusCard .avatar').attr('src', URL_IMG_NO_AVATAR);
    showAdsImgsIcon();
    printMessagesChain(discusVars.messages);
    wsSendGetOnlineStatus(owner.id);
    wsSendMsgStatus(owner.id, discusVars.discus.id, 2);
}
function showAdsImgsIcon(){
    var imgsIcon = discusVars.ads.img_icon;
    var imgs     = discusVars.ads.img;

    $('#frmDiscusCard .loadImgs').empty();

    try{
        var tmpImgs     = imgs.split(',');
        var tmpImgsIcon = imgsIcon.split(',');
        imgs = [];
        imgsIcon = [];
        for (i=0; i<tmpImgs.length; i++){
            if (urlExists(URL_BASE+tmpImgs[i])){
                imgs[i] = tmpImgs[i];
            }
        }
        for (i=0; i<tmpImgsIcon.length; i++){
            if (urlExists(URL_BASE+tmpImgsIcon[i])){
                imgsIcon[i] = tmpImgsIcon[i];
            }
        }
    }catch (e){
        return;
    }
    if (imgsIcon[0].length < 10){
        $('#frmDiscusCard .loadImgs').css('display', 'none');
    }else{
        $('#frmDiscusCard .loadImgs').css('display', 'inline-block');
    }


    discusVars.loadImgs = [];
    for(i=0; i<imgsIcon.length; i++){
        tmpImg = {};
        tmpImg.img  = imgs[i];
        tmpImg.icon = imgsIcon[i];
        discusVars.loadImgs[i] = tmpImg;

    }
    cnt = 0;
    $.each(imgsIcon, function (key, img) {
        if (img && (img!=='')&&(img !==null)) {
            data = '<img src="' + img + '" style="top: ' + cnt * 5 + 'px; left: ' + cnt * 5 + 'px; position: absolute; border: 1px solid #9d9f9d">'
            $('#frmDiscusCard .loadImgs').append(data);
        }
        cnt++;
        if(cnt>3)return false;
    });
}
