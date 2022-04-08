
function initDiscusCard(owner) {
    var time = (discusVars.ads.create_date != null) ?
                discusVars.ads.create_date :
                '--:--';
    var description = (discusVars.ads.description != null) ?
                       discusVars.ads.description :
                       'Что-то очень полезное';

    var category = (discusVars.ads.category != null) ?
                    envVars.catList[discusVars.ads.category] :
                    'Полезная услуга';

    var rating = owner.rating/5+'%';

    var href = '/../user_profile/'+owner.id;
    var cost = ((discusVars.ads.cost != null)&&(discusVars.ads.cost > 0)) ?
                 discusVars.ads.cost+'p.' : '';



    $('#frmDiscusCard .adsData .stars .slider').css('width', rating);

    $('#frmDiscusCard .login').text(owner.login);
    $('#frmDiscusCard .href').attr('href', href);
    $('#frmDiscusCard .time').text(time);
    $('#frmDiscusCard .category').text(category);
    $('#frmDiscusCard .cost').text(cost);
    $('#frmDiscusCard .shortDescription').text(description);
    $('.windowDiscus .fullDescription').text(description);
    $('#frmDiscusCard .profile .online').addClass(owner.id);


    if (urlExists('https://worksn.ru/'+owner.img_icon))
        $('#frmDiscusCard .avatar').attr('src',  owner.img_icon);
    else
        $('#frmDiscusCard .avatar').attr('src',  '/service_img/avatars/no-avatar.jpg');
    showAdsImgsIcon();
    printMessagesChain(discusVars.messages);
    wsSendGetOnlineStatus(owner.id);
    wsSendMsgStatus(owner.id, discusVars.discus.id, 2);
}
function showAdsImgsIcon(){
    $('#frmDiscusCard .loadImgs').empty();

    var imgsIcon = discusVars.ads.img_icon;
    var imgs     = discusVars.ads.img;

    try{
        var tmpImgs     = imgs.split(',');
        var tmpImgsIcon = imgsIcon.split(',');
        imgs = [];
        imgsIcon = [];
        for (i=0; i<tmpImgs.length; i++){
            if (urlExists('https://worksn.ru/'+tmpImgs[i])){
                imgs[i] = tmpImgs[i];
            }
        }
        for (i=0; i<tmpImgsIcon.length; i++){
            if (urlExists('https://worksn.ru/'+tmpImgsIcon[i])){
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
    })
}
