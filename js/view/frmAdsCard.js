function frmAdsCard(ads) {
    var err = false;
    var user = {};
    var description, hRef;
    if(!ads.user_id)err = true;
    if(!ads.user_login)err = true;
    if (err) return '';

    user.id    = ads.user_id;
    user.login = ads.user_login;
    user.rating =    (ads.user_rating)   ? ads.user_rating : 0;
    user.img_icon =  (ads.user_img_icon) ? ads.user_img_icon : URL_IMG_NO_AVATAR;
    description = ads.description ? ads.description.substr(0,400): " ";
    costStr = '';
    if(ads.cost !== null){
        cost = parseFloat(ads.cost);
        if(cost > 999999){
            cost = cost/1000000;
            cost = cost.toFixed(2);
            costStr = cost+'млн.р.';
        }else {
            costStr = cost+'р.';
        }
    }
    var id = 'ads_'+G_.cnt++;
    var createDate = ads.create_date;
    var frmAdsCardStyle = '';

    switch (ads.visible_mode){
        case ADS_VISIBLE_HIDDEN_MANUAL :
            frmAdsCardStyle = ' style="background-color : beige"';
            description = STRING_MSG_HIDDEN;
            break;
        case ADS_VISIBLE_HIDDEN_REMOVE :
            frmAdsCardStyle = ' style="background-color : burlywood"';
            description = STRING_MSG_WAS_REMOVE;
            break;
        case ADS_VISIBLE_HIDDEN_FOR_TIME :
            frmAdsCardStyle = ' style="background-color : antiquewhite"';
            description = STRING_MSG_HIDDEN_FOR_TIME;
            break;

    }
    var imgFrm = getAdsCardImg(ads);
    var width = imgFrm ? ' style="width: 80%;" ' : '';
    adsVars.adsList[id] = ads;
    var frm =
        '<div class="frmAdsCard" id="'+id+'"'+frmAdsCardStyle+'>' +
        '   <table>' +
        '       <tr >' +
        '           <td style="vertical-align: top">' +
                         frmUserProfile(user, true)+
        '           </td>' +
        '           <td class="discusFrameBody"  style="vertical-align: top;width: 100%;">' +
        '               <input type="hidden" name="ads_id" data-id = "'+ads.id+'">' +
        '               <input type="hidden" name="owner_id" data-id = "'+ads.user_id+'">'+
        '               <div style="font-weight: 600; display: inline-block; color: #818381; margin-left: 5%">'+envVars.catList[ads.category]+'</div>'+
        '               <div style="font-weight: 600; display: inline-block; color: #818381; margin-left: 5%">'+costStr+'</div>'+
        '               <div style="font-size: 12px; display: inline-block; float: right">'+createDate+'</div>' +
        '               <div style="vertical-align: top; display: block; position: relative; overflow: hidden">'+
        '                   <div class="description" '+width+'>'+description+'... &nbsp; </div>' +
                            imgFrm+
        '               </div>' +
        '           </td>' +
        '       </tr>' +
        '       <tr><div style="width: 80%; height: 1px; background-color: #9d9f9d; margin-left: 10%"/></tr>' +
        '   </table>' +
        '</div>';
    return frm;
}
function getAdsCardImg(ads) {
    var imgFrm = '';
    if (ads.img_icon){
        img = ads.img_icon.split(',')[0];
        imgFrm ='' +
            '<div style="width: 15%; height: 100%; display: inline-block; float: right">' +
            '    <img src="'+img+'" style="width:100%; height: auto">' +
            '</div>';
    }
    return imgFrm;
}