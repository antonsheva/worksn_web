<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 14.12.2020
 * Time: 23:18
 */

namespace classesPhp;


class ClassAndroidUser
{
    var $user = null;
    public function __construct()
    {
        $this->user = new \structsPhp\StructUser();
        getPostData($this->user);
    }

    function login(){
        global $P;
        $tmp_data = $P->AGet('data');
//        $tmp_data = json_decode($tmp_json, true);
 

        $tmp['par1'] = 'par-1';
        $tmp['par2'] = 'par-2';
        $tmp['par3'] = 'par-3';

        $tmp1['par1'] = 'par-1_1';
        $tmp1['par2'] = 'par-2_1';
        $tmp1['par3'] = 'par-3_1';

        $tmp2['par1'] = $tmp_data['par1'];
        $tmp2['par2'] = $tmp_data['par2'];
        $tmp2['par3'] = $tmp_data['par3'];



        $arr[] = $tmp;
        $arr[] = $tmp1;
        $arr[] = $tmp2;




        $data['data'] = $arr;

        $data['response'] = 'resp-1...';
        $data['error'] = 'error-err...';
        $data['result'] = 'wtf...';
        $str = json_encode($data);
        echo $str;
        exit();
//        mRESP_DATA($_SESSION);





    }
}