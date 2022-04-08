function ACheckDataFields(data, all_data) {
    if(all_data){
        if(!data.login)                    {APopUpMessage('Заполните поля, отмеченные звездочкой', ERROR); return ERROR;}
        if(!data.password)                 {APopUpMessage('Заполните поля, отмеченные звездочкой', ERROR);  return ERROR;}
        if(data.password !== data.rpt_pass){APopUpMessage('Не совпадают пароли!', ERROR);               return ERROR;}
    }
    if(ACheckPhoneNumber(data.phone)===ERROR){return ERROR;}
    if(ACheckEmail      (data.email)===ERROR){return ERROR;}
    return OK;
}
function ACheckPhoneNumber(tel) {
    var error = 0;
    var re = /^(\d|\+7)[\d\(\)\ -]{4,14}\d$/;
    var valid = re.test(tel);
    if(!valid && tel){
        APopUpMessage('Некорректный номер телефона',1);
        return ERROR;
    }
    return OK;
}
function ACheckEmail(email) {
    var re = /^[\w]{1}[\.\w-]*@[\w-]+\.[a-z]{2,4}$/i;
    var valid = re.test(email);
    if(!valid && email){
        APopUpMessage('Некорректный Email', 1);
        return ERROR;
    }
    return OK;
}