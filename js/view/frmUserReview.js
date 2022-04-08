function frmUserReview(data) {
    img_tag = '';
    remove_previous_comment = '';
    if(data.sender_id){
        img_tag = '<img src="/'+CNTXT_.user.img+'" style="height: 30px; width: 30px; border-radius: 5px;">';
        remove_previous_comment = 'removePreviousComment';
    }
    rt ='<div class="frm_user_review '+remove_previous_comment+' ">' +
        '<div>' +
        img_tag+
        '</div>' +
        '<table>' +
        '   <tr>' +
        '       <td class="tm">' +
        data.create_date+
        '       </td>' +
        '   </tr>' +
        '   <tr>' +
        '       <td>' +
        data.comment+
        '       </td>' +
        '   </tr>' +
        '</table>' +
        '</div>';
    return rt;
}


