function removeImg(img){
    var data = {};
    data.act = 'rm_tmp_file';
    data.filename = img;
    APost(data, cbRemoveImg);
}
function changeImg(e){
    if(G_tmp_img){
        var data = {};
        data.act = 'rm_tmp_file';
        data.filename = G_tmp_img;
        APost(data, cbChangeImg);
    }else sendFile();

}

function removeTmpImgs(){
    adsVars.oldImgs     = null;
    adsVars.oldImgsIcon = null;
    data = {};
    data.act = 'rm_tmp_file_list';
    data.img_list = imgVars.tmpImgList;
    APost(data, cbRemoveTmpImgList);
}
function cbRemoveTmpImgList(data) {
}
function cbChangeImg(data) {
    clearTmpImgBox();
    sendFile();
}
function cbRemoveImg(data) {

    var img     = data.context.tmp_img;
    var imgIcon = data.context.tmp_img_icon;
    AShowNewImg(null);
}
function ACbRmvGroupImg(data) {
    var img     = data.context.tmp_img;
    var imgIcon = data.context.tmp_img_icon;
    imgVars.uploadImgs.splice(imgVars.uploadImgs.indexOf(img),1);
    imgVars.uploadImgsIcon.splice(imgVars.uploadImgsIcon.indexOf(imgIcon),1);
    $('#'+G_tmp_obj.target_id).remove();
    delete G_tmp_imgs[G_tmp_obj.target_id];
    refreshImgsPanel();
}
function ASubmitImg(){
    var form = document.forms.add_avatar;
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php");
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4){
            if(xhr.status == 200) {
                data = xhr.responseText;
                try {
                    q = $.parseJSON(data);
                    error = Number.parseInt(q.error);
                    img      = q.context.tmp_img;
                    img_icon = q.context.tmp_img_icon;
                    if(error === 0){
                        if(G_imgType === C_IMG_ADS)addImgToGroup(img, img_icon);
                        else AShowNewImg(img_icon);
                    }else{
                        renderTmpImgBox(null);
                        APopUpMessage(q.data,1);
                    }
                }catch (e){
                }
            }
        }
    };
    xhr.send(formData);
}
function addImgToGroup(img, imgIcon){
    if(!img)return;
    imgVars.uploadImgs.push(img);
    imgVars.uploadImgsIcon.push(imgIcon);

    var imgId = 'imgId_'+G_.img_cnt++;
    arr = img.split('/');
    G_tmp_imgs[imgId] = arr[arr.length -1];
    data =
    '<div class="frm_ads_img" id="'+imgId+'" style="display: inline-block">' +
    '       <input type="hidden" name="imgName" data-name  = "'+img+'">'+
    '       <input type="hidden" name="imgId"   data-id  = "'+imgId+'">' +

    '       <div class="adsImg" data-img = "'+img+'">' +
    '          <img src="'+imgIcon+'" style="height: 150px; width: auto">'+
    '       </div>'+
    '</div>';
    $('.tmpImgGroup').append(data)
    G_tmp_img = null;
    addImgToPanel(imgIcon);
}
function addImgToPanel(img) {
    data =
        '<img class="smallImg" src="'+img+'" style="position: absolute; margin-left: '+G_.img_panel_cnt*7+'px">';
    $('.sendingImgs').append(data);
    G_.img_panel_cnt++;
}
function refreshImgsPanel() {
    G_.img_panel_cnt = 0;
    $('.sendingImgs').empty();
    if(imgVars.uploadImgsIcon){
        $.each(imgVars.uploadImgsIcon, function (index, img) {
            addImgToPanel(img);
        })
    }
}
function CheckImgFile(file){
    var good_ext = false; var good_size = false; var iSize = 0;
    var ext_arr = ['jpg','jpeg','png','gif','webp'];
    var maxsize = 1024*1024*10;
    iSize = $(file)[0].files[0].size;
    if(maxsize > iSize)good_size = true;
    for(i in ext_arr)if('image/'+ext_arr[i] == $(file)[0].files[0].type)good_ext = true;
    var error = '';
    if(!good_ext) error += "Неверное расширение файла. Используйте: .jpg, .jpeg, .png, .gif файлы. ";
    if(error != '')error += "\r\n";
    if(!good_size)error += "Размер файла не должен превышать 5М";
    if(error != ''){
        $(file).val("");
        alert(error);
    }
    var lt_fl_name;
    var fl_name;
    fl_name = $('[name=userfile]').val();
    lt_fl_name = AConvertCyrillicToLatin(fl_name);

    fl_name = lt_fl_name.replace('c:\\fakepath\\','');
    $('[name=latin_filename]').val(fl_name);
    return false;
}
function AShowNewImg(img){
    if(img){
        G_tmp_img =img;
        $('#imgBox>.img').attr('src', img);
        $('[name=userfile]').attr('disabled','true');
    }else{
        clearTmpImgBox()
    }
}
function clearTmpImgBox() {
    G_tmp_img = 0;
    $('#imgBox>.img').attr('src','/service_img/avatars/no-avatar.jpg');
    $('[name=userfile]').removeAttr('disabled');
    $("#add_avatar input[type=file]").val('');
}
function zoomImg(img) {

    if(eventDisable())return;

    renderTmpImgBox(1);
    AShowNewImg(img);
    G_tmpImgState = C_IMG_ZOOM;
    G_tmp_img = null;
}

 