function AConvertCyrillicToLatin(str){
    var rus_arr = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя ';
    var lt_arr = ['a','b','v','g','d','e','e','j','z','i','y','k','l','m','n','o','p','r','s','t','u','f',
        'h','c','ch','sh','shh','_','y','_','e','yu','ya','_'];
    var new_str_latin = '';
    var new_str;
    var i,pos;
    new_str = str.toLocaleLowerCase();
    for(i=0;i<str.length;i++){
        pos = rus_arr.indexOf(new_str[i]);
        if(pos === -1)new_str_latin += new_str[i];
        else new_str_latin += lt_arr[pos];
    }
    return new_str_latin;
}
function AGetContext(data) {
    try{
        for(key in data){
            CNTXT_[key] = data[key];
        }
    }catch (e){

    }

}
function initG(){
    G_.user.id = CNTXT_.user.id;
    G_.user.login =  CNTXT_.user.login;
    G_.owner.id = CNTXT_.owner.id;
    G_.owner.login =  CNTXT_.owner.login;

}
//-------------------- Get Params -----------------------
function GP(id) {
    var data = {};
    $('#'+id).find('input , textarea, select').each(function(key,item){
        par = $(item).attr('class');
        val = $(item).val();
        if(val && (val !==''))data[par] = val;
    });
    return data;
}
//--------------------------------------------------------
function enumeration(data) {
    $.each(data, function (key, item) {
        if((typeof item === 'object') && (item !== null)){
            enumeration(item);
        }
    })
}
function sendFile(){
    $('.chs_file').click();
}
function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}
function urlExists(url){
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}



