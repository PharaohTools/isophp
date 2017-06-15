<?php

namespace Model;

class Navigate {

    public function route($control = null, $action = null) {

        \ISOPHP\js_core::$console->log('In the applications navigation method') ;
        \ISOPHP\js_core::$console->log($_REQUEST, $_SERVER, $control, $action) ;

        $route_set[] = isset($control) ;
        $route_set[] = isset($action) ;

        if ( \ISOPHP\core::$php->in_array(false, $route_set) ) {
            $control = "Index" ;
            $action = "index" ; }

        if (!isset($_REQUEST['output-format'])) {
            $_REQUEST['output-format'] = "HTML"; }

        $cleo_vars = array();
        $cleo_vars[0] = __FILE__;
        $cleo_vars[1] = $control;
        $cleo_vars[2] = $action;
        foreach($_REQUEST as $post_key => $post_var) {
            if (!\ISOPHP\core::$php->in_array($post_key, array('control', 'action'))) {
                $cleo_vars[] = "--$post_key=$_REQUEST[$post_key]" ; } }
        $_ENV['bootstrap'] = \ISOPHP\core::$php->serialize($cleo_vars);

        \ISOPHP\js_core::$console->log($cleo_vars, $_ENV) ;

        $argv_or_null = null ;
        $bootStrapParams = (isset($_ENV['bootstrap'])) ? \ISOPHP\core::$php->unserialize($_ENV['bootstrap']) : $argv_or_null ;
        \ISOPHP\core::$bootstrap->main($bootStrapParams);

    }
    
}