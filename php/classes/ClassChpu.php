<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ClassChpu {
    var $chpu_array = array();
    var $chpu_request = null;
    var $uri_parts;
    var $uri;
    var $uri_copy;
    function __construct(){
        global $G;
        $this->chpu_array['page']     = 'home' ;
        $this->chpu_array['ads_type'] = null ;
        $this->chpu_array['owner_id'] = null ;
        $this->AGetChpuParams();
        $G->location_page = $this->chpu_array['page'];

    }
    function AGetChpuParams(){
        // Назначаем модуль и действие по умолчанию.
        $module = 'index';
        $action = 'index';
        // Массив параметров из URI запроса.
        $params = array();

        // Если запрошен любой URI, отличный от корня сайта.
        if ($_SERVER['REQUEST_URI'] != '/') {
//            try {
            // Для того, что бы через виртуальные адреса можно было также передавать параметры
            // через QUERY_STRING (т.е. через "знак вопроса" - ?param=value),
            // необходимо получить компонент пути - path без QUERY_STRING.
            // Данные, переданные через QUERY_STRING, также как и раньше будут содержаться в
            // суперглобальных массивах $_GET и $_REQUEST.
            $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            // Разбиваем виртуальный URL по символу "/"
            $this->uri = explode('/', trim($url_path, ' /'));
            $this->uri_copy = $this->uri;
            if(count($this->uri)>0)$this->AChpuPageRoutine();
        }

    }
    function AChpuPageRoutine(){
        global $P, $G;
        $this->chpu_request = 1;
        $page = array_shift($this->uri);
        switch($page){
            case 'concept'        : $this->chpu_array['page'    ] = 'concept'               ;    break;
            case 'about'          : $this->chpu_array['page'    ] = 'about'                 ;    break;
            case 'security'       : $this->chpu_array['page'    ] = 'security'              ;    break;
            case 'faq'            : $this->chpu_array['page'    ] = 'faq'                   ;    break;
            case 'recommendations': $this->chpu_array['page'    ] = 'recommendations'       ;    break;
            case 'terms'          : $this->chpu_array['page'    ] = 'terms'                 ;    break;
            case 'privacy'        : $this->chpu_array['page'    ] = 'privacy'               ;    break;
            case 'registration'   : $this->chpu_array['page'    ] = 'registration'          ;    break;
            case 'recovery'       : $this->chpu_array['page'    ] = 'recovery'              ;    break;
            case 'my_profile'     : $this->chpu_array['page'    ] = 'my_profile'            ;    break;
            case 'setting'        : $this->chpu_array['page'    ] = 'setting'               ;    break;
            case 'user_profile'   : $this->chpu_array['page'    ] = 'user_profile'          ;
                                    $P->ASet('owner_id',  array_shift($this->uri))  ;    break;
            case 'user_discus'    : $this->chpu_array['page'    ] = 'home'                  ;
                                    $G->mode = MODE_DISCUS_WITH_USER                        ;
                                    $P->ASet('owner_id',  array_shift($this->uri))  ;    break;
            case 'confirm_email'  : $this->chpu_array['page'    ] = 'confirm_email'         ;
                                    $G->email_user_id = array_shift($this->uri)             ;
                                    $G->email_hash = array_shift($this->uri)                ;    break;
            case 'my_test'        : $this->chpu_array['page'    ] = 'home'                  ;
                                    $G->mode = MODE_TEST                                    ;    break;

//            default : $this->chpu_array['page'    ] =  $page;
        }
    }
}