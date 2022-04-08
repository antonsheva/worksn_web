<?php
namespace structsPhp;
global $A_start;

use structsPhp\dbStruct\tblDiscus;

if($A_start != 444){echo 'byby';exit();}

class SettingPageContent{
    var $name = null;
    var $description = null;
}
class EnvData{
    var $categories      = null;
    var $lifetime        = null;
    var $settingPageData = null;



    function __construct()
    {

        $this->lifetime   = array();
        $this->categories = array();


        $category = new \AssocData();$category->name =  'Все категории'      ; $category->val  = '0'; $category->pos = 0; $this->categories[0]=$category;
        $category = new \AssocData();$category->name =  'Сходить в магазин'  ; $category->val  = '1'; $category->pos = 1; $this->categories[1]=$category;
        $category = new \AssocData();$category->name =  'Курьер'             ; $category->val  = '2'; $category->pos = 2; $this->categories[2]=$category;
        $category = new \AssocData();$category->name =  'Помощь по дому'     ; $category->val  = '3'; $category->pos = 3; $this->categories[3]=$category;
        $category = new \AssocData();$category->name =  'Компьютерная помощь'; $category->val  = '4'; $category->pos = 4; $this->categories[4]=$category;
        $category = new \AssocData();$category->name =  'Ремонт быт. техники'; $category->val  = '5'; $category->pos = 5; $this->categories[5]=$category;
        $category = new \AssocData();$category->name =  'Водитель'           ; $category->val  = '6'; $category->pos = 6; $this->categories[6]=$category;
        $category = new \AssocData();$category->name =  'Куплю/Продам'       ; $category->val  = '7'; $category->pos = 7; $this->categories[7]=$category;
        $category = new \AssocData();$category->name =  'Подарю/Приму в дар' ; $category->val  = '8'; $category->pos = 8; $this->categories[8]=$category;


//        $category = new \AssocData();$category->name =  'category -> 0'; $category->val  = '0'; $category->pos = 0; $this->categories[0]=$category;
//        $category = new \AssocData();$category->name =  'category -> 1'; $category->val  = '1'; $category->pos = 1; $this->categories[1]=$category;
//        $category = new \AssocData();$category->name =  'category -> 2'; $category->val  = '2'; $category->pos = 2; $this->categories[2]=$category;
//        $category = new \AssocData();$category->name =  'category -> 3'; $category->val  = '3'; $category->pos = 3; $this->categories[3]=$category;
//        $category = new \AssocData();$category->name =  'category -> 4'; $category->val  = '4'; $category->pos = 4; $this->categories[4]=$category;
//        $category = new \AssocData();$category->name =  'category -> 5'; $category->val  = '5'; $category->pos = 5; $this->categories[5]=$category;
//        $category = new \AssocData();$category->name =  'category -> 6'; $category->val  = '6'; $category->pos = 6; $this->categories[6]=$category;
//        $category = new \AssocData();$category->name =  'category -> 7'; $category->val  = '7'; $category->pos = 7; $this->categories[7]=$category;
//        $category = new \AssocData();$category->name =  'category -> 8'; $category->val  = '8'; $category->pos = 8; $this->categories[8]=$category;




        $lt = new \AssocData();$lt->name =  '10 минут' ; $lt->val = 600    ; $lt->pos = 0; $this->lifetime[0] = $lt;
        $lt = new \AssocData();$lt->name =  '1 час'    ; $lt->val = 3600   ; $lt->pos = 1; $this->lifetime[1] = $lt;
        $lt = new \AssocData();$lt->name =  '8 часов'  ; $lt->val = 28800  ; $lt->pos = 2; $this->lifetime[2] = $lt;
        $lt = new \AssocData();$lt->name =  '1 день'   ; $lt->val = 86400  ; $lt->pos = 3; $this->lifetime[3] = $lt;
        $lt = new \AssocData();$lt->name =  '7 дней'   ; $lt->val = 604800 ; $lt->pos = 4; $this->lifetime[4] = $lt;
        $lt = new \AssocData();$lt->name =  '30 дней'  ; $lt->val = 2592000; $lt->pos = 5; $this->lifetime[5] = $lt;




        $data = new SettingPageContent() ;
        $data->name               = 'Общие принципы';
        $data->description        = 'https://worksn.ru/concept';
        $this->settingPageData[0] = $data;

        $data = new SettingPageContent() ;
        $data->name               = 'ЧАВО';
        $data->description        = 'https://worksn.ru/faq';
        $this->settingPageData[1] = $data;

        $data = new SettingPageContent() ;
        $data->name               = 'Рекомендации по приложению';
        $data->description        = 'https://worksn.ru/recommendations';
        $this->settingPageData[2] = $data;

        $data = new SettingPageContent() ;
        $data->name               = 'Безопасность';
        $data->description        = 'https://worksn.ru/security';
        $this->settingPageData[3] = $data;

        $data = new SettingPageContent() ;
        $data->name               = 'Политика конфиденциальности';
        $data->description        = 'https://worksn.ru/privacy';
        $this->settingPageData[4] = $data;

        $data = new SettingPageContent() ;
        $data->name               = 'Apk-файл для android (zip)';
        $data->description        = 'https://worksn.ru/apk/worksn.zip';
        $this->settingPageData[5] = $data;

        $data = new SettingPageContent() ;
        $data->name               = 'О проекте';
        $data->description        = 'https://worksn.ru/about';
        $this->settingPageData[6] = $data;

    }

    function getLifetime(){
        return $this->lifetime;
    }
    function getCategories(){
        return $this->categories;
    }
    function getSettingPageData(){
        return $this->settingPageData;
    }
}

