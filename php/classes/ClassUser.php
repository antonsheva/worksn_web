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

define('NEW_USER', 0);
define('UPDATE_USER', 1);
define('UPDATE_AUTO_AUTH', 2);
define('CHNG_PASSWORD', 3);


class ClassUser
{
    var $user = null;
    var $cookie;
    function __construct(){
        global $P;
        $this->cookie = new ClassCookie();
        $this->user   = new \structsPhp\StructUser();
        $this->AGetUser();
        getPostData($this->user);
        $P->AUnSet('password');
    }
 //---------------------   REG NEW USER    ------------------------------
    function ARegistration(){
        global $G;
        $img = null;
        $this->ACheckRegistrationData();
        $this->ACheckUserLoginExist  ();
        $this->ACheckUserEmailExist  ();

        $user_id = $this->AAddUser();
        if ($user_id){
            $user_id = userFillData($user_id, $G->user);
            $response = 'Вы успешно зарегистрированы. Войдите, используя свой логин и пароль.';
            if ($this->user->email_hash)$response .= ' Для подтверждения Email проверьте почту';
            if($user_id)mRESP_DATA($response);
        }
        mRESP_WTF();
    }
    function AAddUser(){
        global $S, $AC_img, $DIR, $A_db, $G;
        $user_id = $A_db->ACreateNewLine('users');
        if($user_id){
            if($S->AGet('tmp_file')){
                $imgPath              = $AC_img->saveImg($S->AGet('tmp_file'),$DIR->avatars);
                $this->user->img      = $imgPath['img'];
                $this->user->img_icon = $imgPath['imgIcon'];
            }else{
                $this->user->img      = $DIR->noAvatar;
                $this->user->img_icon = $DIR->noAvatar; 
            }
            $this->user->remote_addr = $_SERVER['REMOTE_ADDR'];
            return $this->ASaveUserData($user_id, NEW_USER);
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

        if(strpos($login, 'admin') !== false)$error =  true;
        if(strpos($login, 'админ') !== false)$error =  true;
        if(strpos($login, 'логин') !== false)$error =  true;
        if(strpos($login, 'login') !== false)$error =  true;
        return $error;
    }
    function ACheckUserLoginExist(){
        global $A_db;
        $login = $this->user->login;

        if ($this->checkBanedLogin($login))mRESP_DATA('Логин занят', 0,1);

        $query = "SELECT id FROM users WHERE login='$login'";
        $result = $A_db->AGetSingleStringFromDb($query);
        if($result)mRESP_DATA('Логин занят', 0,0);
    }
    function ACheckUserEmailExist(){
        global $A_db, $G;
        $email = $this->user->email;
        if ($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                mRESP_DATA('Укажите корректный email');
            $query = "SELECT id FROM users WHERE email='$email' AND confirm_email='1'";
            $result = $A_db->AGetSingleStringFromDb($query);
            if($result)
                if($G->user->id == $result['id'])  return;
                else mRESP_DATA('Email уже зарегистрирован. Воспользуйтесь формой восстановления доступа к аккаунту');
            $this->user->email_hash = hash("sha256",$G->nSecTime);
        }
    }
    function ASaveUserData($user_id, $type){
        global $A_db, $G, $S;
        $time = hrtime(true);
        $this->user->id = $user_id;
        $G->user_id = $this->user->id;
        switch ($type){
            case NEW_USER :
                $this->user->password = password_hash($this->user->password.PASS_SALT, PASSWORD_DEFAULT);
                $this->user->create_date = $G->dateFull;
                break;
            case UPDATE_USER:
                $this->user->login    = null;
                $this->user->password = null;
                $this->user->create_date = null;
                break;
            case UPDATE_AUTO_AUTH:
                $this->user->password = password_hash($this->user->password.PASS_SALT, PASSWORD_DEFAULT);
                $this->user->create_date = null;
                break;
            case CHNG_PASSWORD:
//                $tmpPass = $this->user->cookie_pass;
                $password = password_hash($this->user->password.PASS_SALT, PASSWORD_DEFAULT);
                $this->user = new \structsPhp\StructUser();

                $this->user->password = $password;


//                $this->user->cookie_pass = $tmpPass;


                break;
        }
        $this->user->ws_token = password_hash($time.$this->user->login, PASSWORD_DEFAULT);
        $this->user->ws_token = substr($this->user->ws_token, 10, 10);
        if ($this->user->email_hash){
            $this->user->confirm_email = 0;
            $this->user->email_hash = $user_id.'/'.$this->user->email_hash;
            $this->addNotify(TXT_CONFIRM_EMAIL_START.$this->user->email.TXT_CONFIRM_EMAIL_END);
            $this->sendMailForConfirmEmail($this->user->email, $this->user->email_hash);
        }
        $ws_token = $this->user->ws_token;
        $this->cookie->ASet('ws_token', $ws_token);
        $S->ASet('ws_token', $ws_token);
        $G->user = $this->user;
        $res = $A_db->ASaveDataToDb($this->user,'users' , $user_id);
        return $res['id'];
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
            if ($res['type'] == NOTIFY_TYPE_CHANGE_EMAIL)$id = $res['id'];
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
//------------------------------------------------------------------------

//-----------  RECOVERY PASSWORD  ----------------------------------------
    function ARecoveryPassword(){
        global $P;
        $email = $P->AGet('email');
        if($email){
            $user_data = $this->AFindEmail($email);
            if($user_data){
                $password = rand();
                $this->user->id = $user_data['id'];
                $this->user->password = $password;
                $this->user->cookie_pass = $password;
                $res = $this->ASaveUserData($this->user->id, CHNG_PASSWORD);
                if($res){
                    $msg = 'Данные для восстановления доступа к аккаунту в WORKSN.RU: '.PHP_EOL;
                    $msg.= 'Логин - '.$user_data['login'].PHP_EOL;
                    $msg.= 'Пароль - '.$password;
                    $res = mail($email,'Восстановление доступа WORKSN.RU',$msg);
                    if($res){
                        $txt = "Новый пароль был отправлен по указанному адресу";
                        mRESP_DATA($txt);
                    }else{
                        mRESP_WTF();
                    }
                }else{
                    mRESP_WTF();
                }
            }else{
                $txt = 'Данная почта не зарегистрирована';
                mRESP_DATA($txt, 0);
            }
        }else{
            $txt = 'Укажите почту';
            mRESP_DATA($txt, 0);
        }
        mRESP_WTF();
    }
    function AFindEmail($email){
        global $A_db;
        $query = "SELECT id, login FROM users WHERE email='$email' AND confirm_email='1'";
        $user_data = $A_db->AGetSingleStringFromDb($query);
        return $user_data;
    }

//----------   LOGIN    --------------------------------------------------
    function ALogin(){
        global $G, $S;

        $this->user->id = $this->ACheckUserData();
        if($this->user->id){
            $this->user->last_time   = $G->dateFull;
            $this->ASaveUserData($this->user->id, UPDATE_USER);
            $this->user->auto_auth = 0;
            $S->ASet(DATA_COMPLETE, 0);
            $res = $this->AInitUser();
            if($res)mRESP_DATA(0);
        }
        mRESP_DATA('Неверный логин или пароль', 0);
    }
    function AInitUser(){
        global $S, $G;
        $user_id = $this->user->id;

        if(!$S->AGet(DATA_COMPLETE)){
           $this->user =  new StructUser();
           $user_id = userFillData($user_id, $this->user);
           $G->user = $this->user;
           if(!$user_id){
               return LOGIN_ERROR;
           }
            $S->ASet(DATA_COMPLETE,1);
        }

        $old_img      = $this->user->img;
        $old_img_icon = $this->user->img_icon;
        $ws_token = $this->user->ws_token;
        $auto_auth = $this->user->auto_auth;


        $S->ASet('auto_auth', $auto_auth);
        $S->ASet('user_id', $user_id);
        $S->ASet('user',session_id());
        $S->ASet('old_img', $old_img);
        $S->ASet('old_img_icon', $old_img_icon);
        $S->ASet('user_data', json_encode($this->user));
        $S->ASet('ws_token', $ws_token);


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
                $hash_pass = $result['password'];
                if (password_verify($password.PASS_SALT, $hash_pass)){
                    return $result['id'];
                }else{
                    return 0;
                }
            }
        }
        return null;
    }
    function AGetUser(){
        global $S, $G;
        $user_id = $S->AGet('user_id');
        if($user_id){
            $srch = '`';
            $rplc = '"';
            $user_data = $S->AGet('user_data');
            $user_data = str_replace($srch,$rplc, $user_data);
            $user_data = json_decode($user_data);
            foreach($G->user as $key=>&$item){
                if(isset($user_data->{$key}))$item = $user_data->{$key};
            }
            $G->user->ws_token = $S->AGet('ws_token');
            $G->user_id = $G->user->id;
        }
    }

//---------   CHNG PASSWORD   --------------------------------------------
    function AChangePassword(){
        global $P;
        $this->user->id = $this->ACheckUserData();
        if($this->user->id){
            $this->user->password = $P->AGet('new_pass');
            if($this->user->password){
                $res = $this->ASaveUserData($this->user->id, CHNG_PASSWORD);
                if($res){
                    mRESP_DATA('Пароль изменен');
                }else{
                    mRESP_WTF();
                }
            }
        }else{
            mRESP_DATA('Неверный старый пароль', 0);
        }
    }

//------------- ANONYMUS LOGIN  ------------------------------------------
    function AAnonymLogin(){
        global $G, $S;
        $user_id = $this->ACheckCookie();
        if($user_id){
            $this->user->last_time   = $G->dateFull;
            $this->ASaveUserData($this->user->id, UPDATE_USER);
            $this->AInitUser();
            mRESP_DATA('ok');
        }else{
            $this->AGenerateNewUser();
            $this->user->id  = $this->AAddUser();
            $this->user->auto_auth = 1;

            if($this->user->id){
                $this->user->last_time   = $G->dateFull;
                $this->ASaveUserData($this->user->id, UPDATE_USER);

////////////////////------   TEST   -----------------///////////////////////////////////

                $this->user->auto_auth = 1;// = 0;

////////////////////////////////////////////////////////////////////////////////////////

                $S->ASet(DATA_COMPLETE, 0);
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
        $this->cookie->ASet('user_id'      ,$this->user->id);
        $this->cookie->ASet('user_login'   ,$this->user->login);
        $this->cookie->ASet('user_password',$this->user->cookie_pass);
        $this->cookie->ASet('auto_login'   , 1);
    }
    function ACheckCookie(){
        $user_id       = $this->cookie->AGet('user_id');
        $user_login    = $this->cookie->AGet('user_login');
        $user_password = $this->cookie->AGet('user_password');
        if($user_id && $user_login && $user_password){
            $this->user->login = $user_login;
            $this->user->password = $user_password;
            $res = $this->ACheckUserData();
            if($res==$user_id){
                $user_id = userFillData($user_id, $this->user);
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
        $this->user->img = "service_img/avatars/no-avatar.jpg";
        $this->user->img_icon = "service_img/avatars/no-avatar.jpg";
    }
    function checkSessionToken($act){
        global $S;
        $arr = ['login', 'anonym_login', 'exit'];
        if(in_array($act, $arr))return;
        if($S->AGet('ws_token') != $this->cookie->AGet('ws_token')){
            mRESP_WTF('WTF_tk');
        }
    }
    function getUserData(){
        global $G;
        if ($G->user_id)$res = 1;
        else            $res = 0;
        mRESP_DATA(0, $res);
    }

//------------------------------------------------------------------------
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
            if($S->AGet('tmp_file')){
                $imgPath              = $AC_img->saveImg($S->AGet('tmp_file'),$DIR->avatars);
                $this->user->img      = $imgPath['img'];
                $this->user->img_icon = $imgPath['imgIcon'];
                if($S->AGet('old_img'))$AC_img->removeImg($S->AGet('old_img'));
                if($S->AGet('old_img_icon'))$AC_img->removeImg($S->AGet('old_img_icon'));
            }
            $S->ASet('tmp_file', null);
            $res = $this->ASaveUserData($user_id,UPDATE_USER);
            if($res){
                $S->ASet(DATA_COMPLETE, 0);

                $str = 'Данные успешно обновлены';
                if($this->user->email_hash){
                    $str .= ' Проверьте почту для подтверждения Email';

                }
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
        if(!$S->AGet('auto_auth') || !$S->AGet('user_id')){
            mRESP_DATA('Что-то пошло не так :-(',0,1);
        } else{
            $user_id = $S->AGet('user_id');
            $this->ACheckRegistrationData();
            $this->ACheckUserLoginExist  ();
            $this->ACheckUserEmailExist  ();
            if($S->AGet('tmp_file')){
                $imgPath              = $AC_img->saveImg($S->AGet('tmp_file'),$DIR->avatars);
                $this->user->img      = $imgPath['img'];
                $this->user->img_icon = $imgPath['imgIcon'];
//                if($S->AGet('old_img'))$AC_img->ARemoveImg($S->AGet('old_img'));
//                if($S->AGet('old_img_icon'))$AC_img->ARemoveImg($S->AGet('old_img_icon'));
            }
            $this->user->auto_auth = 0;
            $this->user->cookie_pass = 0;
            $res = $this->ASaveUserData($user_id,UPDATE_AUTO_AUTH);
            if($res){
                $S->ASet('data_complete', 0);
                $this->AInitUser();
                mRESP_DATA('Данные успешно обновлены');
            }else{
                mRESP_DATA('Что-то пошло не так :-(', 0,1);
            }
        }
    }

//------------- email _---------------------------------------------------
    function sendMailForConfirmEmail($email, $hash){
        global $LOG;
        $href = '<a href="https://worksn.ru/confirm_email/'.$hash.'" target="_blank"> этой ссылке</a>';
        $msg = 'Для подтверждения почтового ящика '.$email.' для WORKSN.RU: '.PHP_EOL;
        $msg.= 'пройдите по: '.$href;
        $header = "Content-type:text/html";
        $res = mail($email,'Подтверждение почтового ящика для WORKSN.RU',$msg, $header);
        $LOG->write('mail() to '.$email.'; result -> '.$res);
    }
    function confirmEmail(){
        global $G, $A_db;
        $userId = $G->user_id;
        $confirmUserId = $G->email_user_id;
        $confirmEmailHash = $G->email_user_id.'/'.$G->email_hash;
        $query = "SELECT email FROM users WHERE (id='$confirmUserId' AND email_hash='$confirmEmailHash')";
        $res = $A_db->AGetSingleStringFromDb($query);
        if ($res){
            $email = $res[0];
            $data[] = array();
            $data['confirm_email'] = 1;
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

//------------------ EXIT ------------------------------------------------
    function AExit(){
        global $S, $G;
//        $ws_token = $S->AGet('ws_token');
        $S->clear();
//        $S->ASet('ws_token', $ws_token);
        $G->user = new StructUser();
        $G->user_id = null;
        $this->cookie->ASet('auto_login', 0);
        $this->cookie->AUnSet('ws_token');
//        $this->cookie->AClear();
        mRESP_DATA(0);
    }
    function exitAndroid(){
        global $S;
        $S->clear();
        $this->cookie->AClear();
        mRESP_DATA(0);
    }

//------------------ TOKEN ------------------------------------------------
    function checkToken($act){
        global $S;
        $arr = [ACT_LOGIN, ACT_ANONYM_LOGIN, ACT_EXIT];
        if(in_array($act, $arr))return;
        if($S->AGet('ws_token') != $this->cookie->AGet('ws_token')){
            mRESP_WTF('WTF_tk');
        }
    }

}














































