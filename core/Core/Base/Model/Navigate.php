<?php

namespace Model;

class Navigate {

    public function route($control = null, $action = null, $params, $new_url = null) {

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
                $cleo_vars[] = "--$post_key=$post_var" ; } }
        $_ENV['bootstrap'] = \ISOPHP\core::$php->serialize($cleo_vars);

        \ISOPHP\js_core::$console->log('Navigate', $cleo_vars, $_ENV, $params) ;

        if (CURRENT_TARGET === 'web') {
            if ($new_url !== null) {
                $ob = array() ;
                \ISOPHP\js_core::$console->log('Navigate URL Change', $ob, $new_url) ;
                $first_char = \ISOPHP\core::$php->substr($new_url, 0, 1) ;
                if ($first_char !== '/') {
                    $new_url = '/'.$new_url ;
                }
                \ISOPHP\js_core::$window->history->replaceState($ob, '', $new_url);
            }
        }

        $argv_or_null = null ;
        $bootStrapParams = (isset($_ENV['bootstrap'])) ? \ISOPHP\core::$php->unserialize($_ENV['bootstrap']) : $argv_or_null ;
        \ISOPHP\core::$bootstrap->main($bootStrapParams, $params);

    }
    
}