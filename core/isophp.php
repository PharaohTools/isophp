<?php


\core::$php = $php ;
\js_core::$console = $console ;
\js_core::$window = $window ;

function __autoload($classname) {

    \js_core::$console->log('Dave is raving') ;
    \js_core::$console->log($classname) ;
    $parts = \core::$php->explode('\\', $classname) ;
    \js_core::$console->log($parts) ;
    if ($parts[0] === 'Core') {
        \js_core::$console->log('Looking in core') ;
        if ($classname == 'Core\Router') {
            $path = '/core/Core/Router.fephp' ;
        } else if ($classname == 'Core\Control') {
            $path = '/core/Core/Control.fephp' ;
        } else if ($classname == 'Core\View') {
            $path = '/core/Core/View.fephp' ;
        }
        if (isset($path)) {
            \js_core::$console->log('found a path ' . $path) ;
            require_once ($path) ;
        }
    }

}

Namespace ISOPHP ;

class core {
    public static $php ;
}

class js_core {
    public static $console ;
    public static $window ;
}