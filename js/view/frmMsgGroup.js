function frmMsgGroup(msg) {
    var err = false;
    if (!msg.speaker_id    )err = true;
    if (!msg.speaker_login )err = true;

    if (err) return;

    if (!msg.speaker_rating)err = true;
    if (!msg.speaker_img   )err = true;


    user = {};
    user.id        = msg.speaker_id;
    user.login     = msg.speaker_login;
    user.rating    = msg.speaker_rating ? msg.speaker_rating : 0;
    user.img_icon  = msg.speaker_img ? msg.speaker_img : "/service_img/avatars/no-avatar.jpg";
    descr = msg.ads_description;
    strContent = msg.content;
    costStr = '';
    if(user.login !== null)user.login = user.login.substr(0,15);
    if((msg.cost != null)&&(msg.cost != 0)){
        cost = parseFloat(msg.cost);
        if(cost > 999999){
            cost = cost/1000000;
            cost = cost.toFixed(2);
            costStr = cost+'млн.р.';
        }else {
            costStr = cost+'р.';
        }
    }

    if(strContent){
        strContent = strContent.length < 40 ? strContent :
            strContent.substr(0,37)+'...';
    }else strContent = ' ';
    if(descr){
        descr = descr.length < 40 ? descr :
            descr.substr(0,37)+'...';
    }else descr = ' ';
    descr += ' '+costStr;
    var id = 'msg_'+G_.cnt++;
    var createDate = msg.create_date;

    var img = msg.img_icon ? msg.img_icon : "/service_img/design/empty_100_100.gif";
    msgVars.messages[id] = msg;
    frm =
        '<div class="frmMsgGroup" id = "'+id+'">' +
        '   <div class="bcgrnd">' +
        '       <img src="/service_img/design/msg_group_bckgrnd.png">' +
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
                        descr+
        '           </a>' +
        '       </div>' +
        '       <div class="time">' +
        '           <a>'+createDate+'</a>' +
        '       </div>' +
        '   </div>' +
        '   <a href="user_profile/'+user.id+'">' +
        '       <div class="avatar" >' +
        '           <img class="online '+user.id+'" src="/service_img/design/online.gif" style="display: none">' +
        '           <object data="/'+user.img_icon+'" class="icon">' +
        '               <img class="icon" src="/service_img/avatars/no-avatar.jpg">' +
        '           </object>' +
        '       </div>' +
        '   </a>'+
        '</div>';
    return frm;
}
