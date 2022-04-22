function frmMsgGroup(msg) {
    var err = false;
    var user = {};
    var description;
    var strContent;
    var costStr = '';
    var frm;
    var id;
    var createDate;
    var img;
    if (!msg.speaker_id    )err = true;
    if (!msg.speaker_login )err = true;

    if (err) return;

    user.id        = msg.speaker_id;
    user.login     = msg.speaker_login;
    user.rating    = msg.speaker_rating ? msg.speaker_rating : 0;
    user.img_icon  = msg.speaker_img ? msg.speaker_img : URL_IMG_NO_AVATAR;
    description = msg.ads_description;
    strContent = msg.content;

    if(user.login !== null)user.login = user.login.substr(0,15);
    if((msg.cost)&&(parseInt(msg.cost !== 0))){
        cost = parseFloat(msg.cost);
        if(cost > 999999){
            cost = cost/1000000;
            cost = cost.toFixed(2);
            costStr = cost+STRING_MLN_R;
        }else {
            costStr = cost+'р.';
        }
    }

    if(strContent){
        strContent = strContent.length < 40 ? strContent : strContent.substr(0,37)+'...';
    }else {
        strContent = ' ';
    }
    if(description){
        description = description.length < 40 ? description : description.substr(0,37)+'...';
    }else {
        description = ' ';
    }
    description += ' '+costStr;
    id = 'msg_'+G_.cnt++;
    createDate = msg.create_date;
    img = msg.img_icon ? msg.img_icon : URL_IMG_EMPTY;
    msgVars.messages[id] = msg;
    frm =
        '<div class="frmMsgGroup" id = "'+id+'">' +
        '   <div class="bcgrnd">' +
        '       <img src="'+URL_IMG_MSG_BACKGROUND+'">' +
        '       <div class="category_login">' +
        '           <div class="category">'+envVars.catList[msg.ads_category]+'</div>' +
        '           <div class="login">'+user.login+'</div>' +
        '       </div>' +
        '       <div class="content">' +
        '           <a>'+strContent+'</a>' +
        '       </div>' +
        '       <div class="ads_description">' +
        '           <div class="content_img">' +
        '              <object data="'+img+'">' +
                            '' +
        '              </object>' +
        '           </div>' +
        '           <a class="text">'+
                        description+
        '           </a>' +
        '       </div>' +
        '       <div class="time">' +
        '           <a>'+createDate+'</a>' +
        '       </div>' +
        '   </div>' +
        '   <a href="user_profile/'+user.id+'">' +
        '       <div class="avatar" >' +
        '           <img class="online '+user.id+'" src="'+URL_IMG_ONLINE+'" style="display: none">' +
        '           <object data="/'+user.img_icon+'" class="icon">' +
        '               <img class="icon" src="'+URL_IMG_NO_AVATAR+'">' +
        '           </object>' +
        '       </div>' +
        '   </a>'+
        '</div>';
    return frm;
}
