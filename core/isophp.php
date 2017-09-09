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
        require (dirname(__DIR__).DIRECTORY_SEPARATOR.'uniter_bundle'.DIRECTORY_SEPARATOR.'file_index.php') ;
        return $file_index ;
    }

}

class js_core {
    public static $console ;
    public static $window ;
    public static $jQuery ;
}

class PHPWrapper {
    
    public function __call($name, $arguments) {
        error_log('this method is ' .$name) ;
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments) ;
        }
    }

}

class console {

    public function log($message) {
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
            error_log('ISOPHP Zend Console: ' .$message) ;
        }
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'UNITER') {
            \ISOPHP\js_core::$console->log('ISOPHP Uniter Console: ' .$message) ;
        }
    }

}