<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 04.03.2021
 * Time: 6:44
 */

namespace classesPhp;


class ClassSearch
{
    public function __construct()
    {

    }

    function search(){
        global $A_db, $A_get_post;
        $error = 0;
        $query_words = '';
        if(!($text = $A_get_post->AGetVariable('search_text')))exit;
        if($error)AErrorLog('SEARCH_ERROR,ASearch');
        $search_text = urldecode($text);
        $search_words = explode(' ', $search_text);
        foreach($search_words as $key=>$item):
            if(strlen($item)>10){
                $item = substr($item,0,strlen($item)-4);
            }
            elseif(strlen($item)>8){
                $item = substr($item,0,strlen($item)-2);
            }
            $query_words .=" description LIKE '%$item%'";
            if($key < (count($search_words)-1)) $query_words .=" AND ";
        endforeach;
        $query = "SELECT * FROM products WHERE ".$query_words;
        $result = $A_db->AGetMultiplyDataFromDb($query);
        return $result;
    }
}