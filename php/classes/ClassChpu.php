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
        $this->chpu_array[STR_PAGE]     = PAGE_HOME ;
        $this->chpu_array[STR_ADS_TYPE] = null ;
        $this->chpu_array[STR_OWNER_ID] = null ;
        $this->AGetChpuParams();
        $G->location_page = $this->chpu_array[STR_PAGE];

    }
    function AGetChpuParams(){
        if ($_SERVER[STR_REQUEST_URI] != '/') {
            $url_path = parse_url($_SERVER[STR_REQUEST_URI], PHP_URL_PATH);
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
            case PAGE_CONCEPT        : $this->chpu_array[STR_PAGE    ] = PAGE_CONCEPT         ;    break;
            case PAGE_ABOUT          : $this->chpu_array[STR_PAGE    ] = PAGE_ABOUT           ;    break;
            case PAGE_SECURITY       : $this->chpu_array[STR_PAGE    ] = PAGE_SECURITY        ;    break;
            case PAGE_FAQ            : $this->chpu_array[STR_PAGE    ] = PAGE_FAQ             ;    break;
            case PAGE_RECOMMENDATIONS: $this->chpu_array[STR_PAGE    ] = PAGE_RECOMMENDATIONS ;    break;
            case PAGE_TERMS          : $this->chpu_array[STR_PAGE    ] = PAGE_TERMS           ;    break;
            case PAGE_PRIVACY        : $this->chpu_array[STR_PAGE    ] = PAGE_PRIVACY         ;    break;
            case PAGE_REGISTRATION   : $this->chpu_array[STR_PAGE    ] = PAGE_REGISTRATION    ;    break;
            case PAGE_RECOVERY       : $this->chpu_array[STR_PAGE    ] = PAGE_RECOVERY        ;    break;
            case PAGE_MY_PROFILE     : $this->chpu_array[STR_PAGE    ] = PAGE_MY_PROFILE      ;    break;
            case PAGE_SETTING        : $this->chpu_array[STR_PAGE    ] = PAGE_SETTING         ;    break;
            case PAGE_USER_PROFILE   : $this->chpu_array[STR_PAGE    ] = PAGE_USER_PROFILE    ;
                                    $P->ASet(STR_OWNER_ID,  array_shift($this->uri))  ;    break;
            case PAGE_USER_DISCUS    : $this->chpu_array[STR_PAGE    ] = PAGE_HOME            ;
                                    $G->mode = MODE_DISCUS_WITH_USER                          ;
                                    $P->ASet(STR_OWNER_ID,  array_shift($this->uri))  ;    break;
            case PAGE_CONFIRM_EMAIL  : $this->chpu_array[STR_PAGE    ] = PAGE_CONFIRM_EMAIL   ;
                                    $G->email_user_id = array_shift($this->uri)               ;
                                    $G->email_hash = array_shift($this->uri)                  ;    break;
            case PAGE_MY_TEST        : $this->chpu_array[STR_PAGE    ] = PAGE_HOME            ;
                                    $G->mode = MODE_TEST                                      ;    break;
        }
    }
}