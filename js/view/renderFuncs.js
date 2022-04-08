function renderTmpImgBox(show){
    if(show){
        $('.mainScreen').css('opacity', '0.3')
        $('.imgGrp').css('opacity', '0.3')
        $('.tmpImgBox').css('display', 'block');
    }else {
        $('.mainScreen').css('opacity', '1.0')
        $('.imgGrp').css('opacity', '1.0')
        $('.tmpImgBox').css('display', 'none');
        renderImgMsgForm(false)
        clearTmpImgBox();
        G_tmpImgState = C_IMG_HIDDEN;
    }
}
function renderImgMsgForm(show) {
    if(show){
        content = $('#frmSendMsgForm .content').val();
        $('#sendImgMsg').css('display', 'block');
        $('#sendImgMsg .content').val(content);
        $('#sendImgMsg .content').focus();
        $('#frmSendMsgForm .content').prop('disabled', true)
        $('#frmSendMsgForm .bt').prop('disabled', true)
        $('#frmSendMsgForm .gallerySign').prop('disabled', true)
    }else {
        content = $('#sendImgMsg .content').val();
        $('#frmSendMsgForm .content').val(content);
        $('#sendImgMsg').css('display', 'none');

        $('#frmSendMsgForm .content').prop('disabled', false)
        $('#frmSendMsgForm .bt').prop('disabled', false)
        $('#frmSendMsgForm .gallerySign').prop('disabled', false)
    }
}
function renderTmpImgGroup(show){
    if(show){
        $('.mainScreen').css('opacity', '0.3')
        $('.tmpImgBox').css('display', 'none');
        $('.imgGrp').css('display', 'block');
    }else {
        $('.mainScreen').css('opacity', '1.0')
        $('.tmpImgBox').css('display', 'none');
        $('.imgGrp').css('display', 'none');
    }
}
function showImgArray() {
    $('.tmpImgGroup').empty();
    $('.sendingImgs ').empty();
    renderTmpImgGroup(1);
    $.each(discusVars.loadImgs, function (key, item) {
        if(item.img){
            data =
                '<div class="adsImg" data-img = "'+item.img+'" style="height: 150px; width: auto; display: inline-block">' +
                '   <img src="'+item.icon+'" style="height: 150px; width: auto">'+
                '</div>';
            $('.tmpImgGroup').append(data)
            addImgToPanel(item.icon);
        }
    })
}





