<?php

namespace Model;

class RegistryStore {

    public $store ;

    public function setValue($variable, $value) {
        \ISOPHP\js_core::$console->log('set val ', $variable, $value) ;

        $the_ray = array( $variable => $value ) ;
        \ISOPHP\js_core::$console->log('the ray ', $the_ray) ;
        \ISOPHP\js_core::$console->log('the store ', \ISOPHP\core::$data_ray) ;

//        if (!is_array(\ISOPHP\core::$data_ray)) {
//            \ISOPHP\core::$data_ray = array() ;
//        }

        $data_ray = \ISOPHP\core::$data_ray ;
        $data_ray[$variable] = $value ;

        \ISOPHP\js_core::$console->log('new ray ', $data_ray) ;
        \ISOPHP\core::$data_ray = $data_ray ;
        \ISOPHP\js_core::$console->log('after set val ', \ISOPHP\core::$data_ray) ;
        return $data_ray[$variable] ;
    }

    public function getValue($variable) {
        return \ISOPHP\core::$data_ray[$variable] ;
    }

}