<?php

namespace Model ;

class Configuration {

    public static $SERVER_URL ;

    public function __construct() {
        $variables = array() ;
        require_once (__DIR__.DIRECTORY_SEPARATOR.'default.php') ;
        self::$SERVER_URL = 'http://server.'.$variables['domain'] ;
    }

}

