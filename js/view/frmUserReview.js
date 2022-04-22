function frmUserReview(data) {
    var imgTag = '';
    var rmvPrevComment = '';
    var frm;
    if(data.sender_id){
        imgTag = '<img src="/'+CNTXT_.user.img+'" style="height: 30px; width: 30px; border-radius: 5px;">';
        rmvPrevComment = 'removePreviousComment';
    }
    frm ='<div class="frm_user_review '+rmvPrevComment+' ">' +
        '<div>' +
            imgTag+
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
    return frm;
}