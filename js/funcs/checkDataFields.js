function ACheckDataFields(data, all_data) {
    if(all_data){
        if(!data.login)                    {APopUpMessage(STRING_NEED_FIELDS, ERROR); return ERROR;}
        if(!data.password)                 {APopUpMessage(STRING_NEED_FIELDS, ERROR);  return ERROR;}
        if(data.password !== data.rpt_pass){APopUpMessage(STRING_PASS_NOT_EQUAL, ERROR);               return ERROR;}
    }
    if(ACheckPhoneNumber(data.phone)===ERROR){return ERROR;}
    if(ACheckEmail      (data.email)===ERROR){return ERROR;}
    return OK;
}
function ACheckPhoneNumber(tel) {
    var re = /^(\d|\+7)[\d\(\)\ -]{4,14}\d$/;
    var valid = re.test(tel);
    if(!valid && tel){
        APopUpMessage(STRING_BAD_PHONE,1);
        return ERROR;
    }
    return OK;
}
function ACheckEmail(email) {
    var re = /^[\w]{1}[\.\w-]*@[\w-]+\.[a-z]{2,4}$/i;
    var valid = re.test(email);
    if(!valid && email){
        APopUpMessage(STRING_BAD_EMAIL, 1);
        return ERROR;
    }
    return OK;
}