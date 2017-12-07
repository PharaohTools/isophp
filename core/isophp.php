<?php

Namespace ISOPHP ;

class core {

    public static $bootstrap ;
    public static $php ;
    public static $file_index ;
    public static $registry ;
    public static $object_to_array ;
    public static $data_ray ;

    public static function load_file_index() {
        $file_index = array() ;
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
            require (REQUIRE_PREFIX.DIRECTORY_SEPARATOR.'uniter_bundle'.DIRECTORY_SEPARATOR.'file_index.fephp') ;
        } else {
            require (REQUIRE_PREFIX.DIRECTORY_SEPARATOR.'uniter_bundle'.DIRECTORY_SEPARATOR.'file_index.fephp') ;
        }
        return $file_index ;
    }

}

class js_core {
    public static $console ;
    public static $window ;
    public static $jQuery ;
}

class cordova_core {
    public static $cordova ;
    public static $navigator ;
}

class PHPWrapper {
    
    public function __call($name, $arguments) {
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments) ;
        }
    }

    public function error_log($message) {
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
            error_log('ISOPHP Zend Error Log: ' . $message) ;
        }
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'UNITER') {
//            \ISOPHP\js_core::$console->log('ISOPHP Uniter Error Log: ' . $message) ;
        }
    }

}

class console {

    public static function log($message) {
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
//            error_log('ISOPHP Zend Console: ' .$message) ;
        }
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'UNITER') {
//            \ISOPHP\js_core::$console->log('ISOPHP Uniter Console: ' .$message) ;
        }
    }

}