<?php
namespace classesPhp;
global $A_start;
use framesView\registrationHref;
use structsPhp\dbStruct\tblNotify;
use structsPhp\StructNotify;
use function React\Promise\resolve;
use structsPhp\G;
use structsPhp\StructUser;

if($A_start != 444){echo 'byby';exit();}



class ClassUser
{
    var $user = null;
    var $cookie;
    function __construct(){
        global $P;
        $this->cookie = new ClassCookie();
        $this->user   = new \structsPhp\StructUser();
        $this->AGetUser();
        $P->getAllData($this->user);
        $P->AUnSet(STR_PASSWORD);
    }
    function ARegistration(){
        global $G;
        $img = null;
        $this->ACheckRegistrationData();
        $this->ACheckUserLoginExist  ();
        $this->ACheckUserEmailExist  ();

        $user_id = $this->AAddUser();
        if ($user_id){
            $user_id = $this->userFillData($user_id, $G->user);
            $response = STRING_YOU_ARE_REGISTERED;
            if ($this->user->email_hash)$response .= STRING_YOUR_EMAIL;
            if($user_id)mRESP_DATA($response);
        }
        mRESP_WTF();
    }
    function AAddUser(){
        global $S, $AC_img, $DIR, $A_db, $G;
        $user_id = $A_db->ACreateNewLine(TBL_USERS);
        if($user_id){
            if($S->AGet(STR_TMP_IMG)){
                $imgPath              = $AC_img->saveImg($S->AGet(STR_TMP_IMG),PATH_AVATARS);
                $this->user->img      = $imgPath[STR_IMG];
                $this->user->img_icon = $imgPath[STR_IMG_ICON];
            }else{
                $this->user->img      = URL_IMG_NO_AVATAR;
                $this->user->img_icon = URL_IMG_NO_AVATAR;
            }
            $this->user->remote_addr = $_SERVER[STR_REMOTE_ADDR];
            return $this->ASaveUserData($user_id, DATA_TYPE_NEW_USER);
        }
        return 0;
    }
    function ACheckRegistrationData(){
        if (!$this->user->login || !$this->user->password){
            mRESP_WTF();
        }
    }
    function checkBanedLogin($login){
        $error = false;
        $login = strtolower($login);

//        if(strpos($login,'admin') !== false)$error =  true;
//        if(strpos($login,'админ') !== false)$error =  true;
//        if(strpos($login,'логин') !== false)$error =  true;
//        if(strpos($login,'login') !== false)$error =  true;
//

        foreach (BAD_LOGIN as $badLogin){
            if(strpos($login,$badLogin) !== false)$error =  true;
        }
        return $error;
    }
    function ACheckUserLoginExist(){
        global $A_db;
        $login = $this->user->login;

        if ($this->checkBanedLogin($login))mRESP_DATA(STRING_LOGIN_EXIST, 0,1);

        $query = "SELECT id FROM users WHERE login='$login'";
        $result = $A_db->AGetSingleStringFromDb($query);
        if($result)mRESP_DATA(STRING_LOGIN_EXIST, 0,0);
    }
    function ACheckUserEmailExist(){
        global $A_db, $G;
        $email = $this->user->email;
        $emailStatus = EMAIL_STATUS_CONFIRM;
        if ($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                mRESP_DATA(STRING_BAD_EMAIL);
            $query = "SELECT id FROM users WHERE email='$email' AND confirm_email='$emailStatus'";
            $result = $A_db->AGetSingleStringFromDb($query);
            if($result)
                if($G->user->id == $result[STR_ID])  return;
                else mRESP_DATA(STRING_EMAIL_EXIST);
            $this->user->email_hash = hash("sha256",$G->nSecTime);
        }
    }
    function ASaveUserData($user_id, $type){
        global $A_db, $G, $S;
        $time = hrtime(true);
        $this->user->id = $user_id;
        $G->user_id = $this->user->id;
        switch ($type){
            case DATA_TYPE_NEW_USER :
                $this->user->password = password_hash($this->user->password.PASS_SALT, PASSWORD_DEFAULT);
                $this->user->create_date = $G->dateFull;
                break;
            case DATA_TYPE_UPDATE_USER:
                $this->user->login    = null;
                $this->user->password = null;
                $this->user->create_date = null;
                break;
            case DATA_TYPE_UPDATE_AUTO_AUTH:
                $this->user->password = password_hash($this->user->password.PASS_SALT, PASSWORD_DEFAULT);
                $this->user->create_date = null;
                break;
            case DATA_TYPE_CHNG_PASSWORD:
                $password = password_hash($this->user->password.PASS_SALT, PASSWORD_DEFAULT);
                $this->user = new \structsPhp\StructUser();

                $this->user->password = $password;
                break;
        }
        $this->user->ws_token = password_hash($time.$this->user->login, PASSWORD_DEFAULT);
        $this->user->ws_token = substr($this->user->ws_token, 10, 10);
        if ($this->user->email_hash){
            $this->user->confirm_email = 0;
            $this->user->email_hash = $user_id.'/'.$this->user->email_hash;
            $this->addNotify(stringNotifyConfirmEmail($this->user->email));
            $this->sendMailForConfirmEmail($this->user->email, $this->user->email_hash);
        }
        $ws_token = $this->user->ws_token;
        $this->cookie->ASet(STR_WS_TOKEN, $ws_token);
        $S->ASet(STR_WS_TOKEN, $ws_token);
        $G->user = $this->user;
        $res = $A_db->ASaveDataToDb($this->user,TBL_USERS , $user_id);
        return $res[STR_ID];
    }
    function addNotify($content, $img = null, $type = 0){
        global $A_db, $G;
        $id = null;
        $userId = $G->user_id;
        $notify = new tblNotify();
        $notify->user_id = $userId;
        $notify->create_date = $G->dateFull;
        $notify->content = $content;
        $notify->type = $type;
        $notify->view = 0;
        if ($img)$notify->img = $img;

        $query = "SELECT id, type FROM notify WHERE user_id = '$userId'";
        $res = $A_db->AGetSingleStringFromDb($query);
        if ($res){
            if ($res[STR_TYPE] == NOTIFY_TYPE_CHANGE_EMAIL)$id = $res[STR_ID];
        }
        $A_db->ASaveStructToDb($notify, TBL_NOTIFY, $id);
    }
    function ACreateNewUserOnDb(){
        global $A_db;
        $query = "INSERT INTO users  VALUES ()";
        $result = $A_db->AQueryToDB($query);
        if ($result)return $A_db->last_insert_id;
        else        return null;
    }
    function ARecoveryPassword(){
        global $P;
        $email = $P->AGet(STR_EMAIL);
        if($email){
            $user_data = $this->AFindEmail($email);
            if($user_data){
                $password = rand();
                $this->user->id = $user_data[STR_ID];
                $this->user->password = $password;
                $this->user->cookie_pass = $password;
                $res = $this->ASaveUserData($this->user->id, DATA_TYPE_CHNG_PASSWORD);
                if($res){
                    $msg = STRING_DATA_FOR_RECOVERY.PHP_EOL;
                    $msg.= STRING_LOGIN_.$user_data[STR_LOGIN].PHP_EOL;
                    $msg.= STRING_PASSWORD_.$password;
                    $res = mail($email,STRING_RECOVERY_ACCESS,$msg);
                    if($res){
                        $txt = STRING_NEW_PASS_WAS_SEND_;
                        mRESP_DATA($txt);
                    }else{
                        mRESP_WTF();
                    }
                }else{
                    mRESP_WTF();
                }
            }else{
                $txt = STRING_EMAIL_NOT_FOUND;
                mRESP_DATA($txt, 0);
            }
        }else{
            $txt = STRING_ENTER_EMAIL;
            mRESP_DATA($txt, 0);
        }
        mRESP_WTF();
    }
    function AFindEmail($email){
        global $A_db;
        $emailStatus = EMAIL_STATUS_CONFIRM;
        $query = "SELECT id, login FROM users WHERE email='$email' AND confirm_email='$emailStatus'";
        $user_data = $A_db->AGetSingleStringFromDb($query);
        return $user_data;
    }
    function ALogin(){
        global $G, $S;

        $this->user->id = $this->ACheckUserData();
        if($this->user->id){
            $this->user->last_time   = $G->dateFull;
            $this->ASaveUserData($this->user->id, DATA_TYPE_UPDATE_USER);
            $this->user->auto_auth = 0;
            $S->ASet(STR_DATA_COMPLETE, 0);
            $res = $this->AInitUser();
            if($res)mRESP_DATA(0);
        }
        mRESP_DATA(STRING_BAT_LOGIN_PASSWORD, 0);
    }
    function AInitUser(){
        global $S, $G;
        $user_id = $this->user->id;

        if(!$S->AGet(STR_DATA_COMPLETE)){
           $this->user =  new StructUser();
           $user_id = $this->userFillData($user_id, $this->user);
           $G->user = $this->user;
           if(!$user_id){
               return LOGIN_ERROR;
           }
            $S->ASet(STR_DATA_COMPLETE,1);
        }

        $old_img      = $this->user->img;
        $old_img_icon = $this->user->img_icon;
        $ws_token = $this->user->ws_token;
        $auto_auth = $this->user->auto_auth;


        $S->ASet(STR_AUTO_AUTH, $auto_auth);
        $S->ASet(STR_USER_ID, $user_id);
        $S->ASet(STR_USER,session_id());
        $S->ASet(STR_OLD_IMG, $old_img);
        $S->ASet(STR_OLD_IMG_ICON, $old_img_icon);
        $S->ASet(STR_USER_DATA, json_encode($this->user));
        $S->ASet(STR_WS_TOKEN, $ws_token);


        return LOGIN_OK;
    }
    function ACheckUserData(){
        global $A_db;
        if($this->user->login && $this->user->password){
            $login = $this->user->login;
            $password = $this->user->password;
            $query = "SELECT id, password FROM users WHERE login='$login'";
            $result = $A_db->AGetSingleStringFromDb($query);
            if($result){
                $hash_pass = $result[STR_PASSWORD];
                if (password_verify($password.PASS_SALT, $hash_pass)){
                    return $result[STR_ID];
                }else{
                    return 0;
                }
            }
        }
        return null;
    }
    function AGetUser(){
        global $S, $G;
        $user_id = $S->AGet(STR_USER_ID);
        if($user_id){
            $srch = '`';
            $rplc = '"';
            $user_data = $S->AGet(STR_USER_DATA);
            $user_data = str_replace($srch,$rplc, $user_data);
            $user_data = json_decode($user_data);
            foreach($G->user as $key=>&$item){
                if(isset($user_data->{$key}))$item = $user_data->{$key};
            }
            $G->user->ws_token = $S->AGet(STR_WS_TOKEN);
            $G->user_id = $G->user->id;
        }
    }
    function AChangePassword(){
        global $P;
        $this->user->id = $this->ACheckUserData();
        if($this->user->id){
            $this->user->password = $P->AGet(STR_NEW_PASS);
            if($this->user->password){
                $res = $this->ASaveUserData($this->user->id, DATA_TYPE_CHNG_PASSWORD);
                if($res){
                    mRESP_DATA(STRING_PASS_WAS_CHANGE);
                }else{
                    mRESP_WTF();
                }
            }
        }else{
            mRESP_DATA(STRING_BAD_OLD_PASS, 0);
        }
    }
    function AAnonymLogin(){
        global $G, $S;
        $user_id = $this->ACheckCookie();
        if($user_id){
            $this->user->last_time   = $G->dateFull;
            $this->ASaveUserData($this->user->id, DATA_TYPE_UPDATE_USER);
            $this->AInitUser();
            mRESP_DATA(0);
        }else{
            $this->AGenerateNewUser();
            $this->user->id  = $this->AAddUser();
            $this->user->auto_auth = 1;

            if($this->user->id){
                $this->user->last_time   = $G->dateFull;
                $this->ASaveUserData($this->user->id, DATA_TYPE_UPDATE_USER);
                $this->user->auto_auth = 1;
                $S->ASet(STR_DATA_COMPLETE, 0);
                $res = $this->AInitUser();
                $this->AInitCookie();
                if($res)mRESP_DATA(0);
            }else{
                mRESP_WTF();
            }
        }
        mRESP_WTF();
    }
    function AInitCookie(){
        $this->cookie->ASet(STR_USER_ID      ,$this->user->id);
        $this->cookie->ASet(STR_USER_LOGIN   ,$this->user->login);
        $this->cookie->ASet(STR_USER_PASSWORD,$this->user->cookie_pass);
        $this->cookie->ASet(STR_AUTO_LOGIN   , 1);
    }
    function ACheckCookie(){
        $user_id       = $this->cookie->AGet(STR_USER_ID);
        $user_login    = $this->cookie->AGet(STR_USER_LOGIN);
        $user_password = $this->cookie->AGet(STR_USER_PASSWORD);
        if($user_id && $user_login && $user_password){
            $this->user->login = $user_login;
            $this->user->password = $user_password;
            $res = $this->ACheckUserData();
            if($res==$user_id){
                $user_id = $this->userFillData($user_id, $this->user);
                return $user_id;
            }else{
                $this->cookie->AClear();
            }
        }
        return 0;
    }
    function AGenerateNewUser(){
        $this->user->login     = 'u'.substr(hrtime(true),0,15);
        $this->user->password  = substr((hrtime(true)*2),2,8);
        $this->user->cookie_pass = $this->user->password;
        $this->user->auto_auth = 1;
        $this->user->img = URL_IMG_NO_AVATAR;
        $this->user->img_icon = URL_IMG_NO_AVATAR;
    }
    function checkSessionToken($act){
        global $S;
        $arr = [ACT_LOGIN, ACT_ANONYMOUS_LOGIN, ACT_EXIT];
        if(in_array($act, $arr))return;
        if($S->AGet(STR_WS_TOKEN) != $this->cookie->AGet(STR_WS_TOKEN)){
            mRESP_WTF();
        }
    }
    function getUserData(){
        global $G;
        if ($G->user_id)$res = 1;
        else            $res = 0;
        mRESP_DATA(0, $res);
    }
    function checkNewNotify(){
        global $A_db, $G;
        $userId = $G->user_id;
        $query = "SELECT id FROM notify WHERE (user_id=$userId AND view=0)";
        $res = $A_db->AGetSingleStringFromDb($query);
        if ($res){
            mRESP_DATA(0,1);
        }
        mRESP_DATA(0,0);
    }
    function getAllNotify(){
        global $A_db, $G;
        $userId = $G->user_id;
        $query = "SELECT * FROM notify WHERE user_id=$userId";
        $res = $A_db->AGetMultiplyDataFromDb($query);
        if ($res){
            $G->notifies = $res;
        }
        mRESP_DATA(0);
    }
    function getNewNotify(){
        global $A_db, $G;
        $userId = $G->user_id;
        $query = "SELECT * FROM notify WHERE (user_id=$userId AND view=0)";
        $res = $A_db->AGetMultiplyDataFromDb($query);
        if ($res){
            $query = "UPDATE notify SET view=1 WHERE user_id=$userId";
            $A_db->AQueryToDB($query);
            $G->notifies = $res;
        }
        mRESP_DATA(0);
    }
    function AUpdtUserData(){
        global $DIR, $AC_img, $S, $G;
        $user_id = $G->user_id;
        if($user_id){
            if ($this->user->email)
                $this->ACheckUserEmailExist();

            $this->user->img = null;
            if($S->AGet(STR_TMP_IMG)){
                $imgPath              = $AC_img->saveImg($S->AGet(STR_TMP_IMG),PATH_AVATARS);
                $this->user->img      = $imgPath[STR_IMG];
                $this->user->img_icon = $imgPath[STR_IMG_ICON];
                if($S->AGet(STR_OLD_IMG))$AC_img->removeImg($S->AGet(STR_OLD_IMG));
                if($S->AGet(STR_OLD_IMG_ICON))$AC_img->removeImg($S->AGet(STR_OLD_IMG_ICON));
            }
            $S->ASet(STR_TMP_IMG, null);
            $res = $this->ASaveUserData($user_id,DATA_TYPE_UPDATE_USER);
            if($res){
                $S->ASet(STR_DATA_COMPLETE, 0);

                $str = STRING_DATA_WAS_CHANGE;
                if($this->user->email_hash)
                    $str .= STRING_CHECK_EMAIL;

                $this->AInitUser();
                mRESP_DATA($str);
            }else{
                mRESP_WTF();
            }
        }else{
            mRESP_WTF();
        }
    }
    function AUpdateAutoAuthData(){
        global $DIR, $AC_img, $S;
        if(!$S->AGet( STR_AUTO_AUTH) || !$S->AGet(STR_USER_ID)){
            mRESP_WTF();
        } else{
            $user_id = $S->AGet(STR_USER_ID);
            $this->ACheckRegistrationData();
            $this->ACheckUserLoginExist  ();
            $this->ACheckUserEmailExist  ();
            if($S->AGet(STR_TMP_IMG)){
                $imgPath              = $AC_img->saveImg($S->AGet(STR_TMP_IMG),PATH_AVATARS);
                $this->user->img      = $imgPath[STR_IMG];
                $this->user->img_icon = $imgPath[STR_IMG_ICON];
            }
            $this->user->auto_auth = 0;
            $this->user->cookie_pass = 0;
            $res = $this->ASaveUserData($user_id,DATA_TYPE_UPDATE_AUTO_AUTH);
            if($res){
                $S->ASet(STR_DATA_COMPLETE, 0);
                $this->AInitUser();
                mRESP_DATA(STRING_DATA_WAS_CHANGE);
            }else{
                mRESP_WTF();
            }
        }
    }
    function sendMailForConfirmEmail($email, $hash){
        $href = stringForConfirmEmail($hash);
        $msg  = stringMsgForConfirmEmail($email, $href);
        $header = "Content-type:text/html";
        mail($email,STRING_MSG_CONFIRM_EMAIL,$msg, $header);
    }
    function confirmEmail(){
        global $G, $A_db;
        $confirmUserId = $G->email_user_id;
        $confirmEmailHash = $G->email_user_id.'/'.$G->email_hash;
        $query = "SELECT email FROM users WHERE (id='$confirmUserId' AND email_hash='$confirmEmailHash')";
        $res = $A_db->AGetSingleStringFromDb($query);
        if ($res){
            $email = $res[0];
            $query = "UPDATE users SET confirm_email='1', email_hash=NULL, system_notify=NULL, notify_id=0 WHERE id='$confirmUserId'";
            $res = $A_db->AQueryToDB($query);
            if ($res){
                $query = "UPDATE users SET email=NULL, email_hash=NULL WHERE (email='$email' AND confirm_email='0')";
                $A_db->AQueryToDB($query);
                $query = "DELETE FROM notify WHERE user_id=$confirmUserId AND type=0";
                $A_db->AQueryToDB($query);
                return $email;
            }
        } return 0;
    }
    function AExit(){
        global $S, $G;
        $S->clear();
        $G->user = new StructUser();
        $G->user_id = null;
        $this->cookie->ASet(STR_AUTO_LOGIN, 0);
        $this->cookie->AUnSet(STR_WS_TOKEN);
        mRESP_DATA(0);
    }
    function exitAndroid(){
        global $S;
        $S->clear();
        $this->cookie->AClear();
        mRESP_DATA(0);
    }
    function checkToken($act){
        global $S;
        $arr = [ACT_LOGIN, ACT_ANONYMOUS_LOGIN, ACT_EXIT];
        if(in_array($act, $arr))return;
        if($S->AGet(STR_WS_TOKEN) != $this->cookie->AGet(STR_WS_TOKEN)){
            mRESP_WTF();
        }
    }
    function userFillData($user_id, \structsPhp\StructUser &$user, $fields = null){
        global $A_db, $G;
        $flds = '*';
        if($fields){
            $flds = '';
            foreach($fields as $item){
                $flds.= $item.', ';
            }
            $flds = substr($flds, 0, strlen($flds)-2);
        }

        $query = "SELECT $flds FROM users WHERE id='$user_id'";
        $res = $A_db->AGetSingleStringFromDb($query);
        if($res){
            foreach($user as $key=>&$item){
                if(isset($res[$key]))$item = $res[$key];
            }
            return $user_id;
        }
        return 0;
    }
}














































