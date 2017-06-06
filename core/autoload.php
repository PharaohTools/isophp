<?php

class core {
    public static $php ;
}

class js_core {
    public static $console ;
    public static $window ;
}

\core::$php = $php ;
\js_core::$console = $console ;
\js_core::$window = $window ;

function __autoload($classname) {
    \js_core::$console->log('Dave is raving') ;
    \js_core::$console->log($classname) ;

    $parts = \core::$php->explode('\\', $classname) ;


    \js_core::$console->log($parts) ;


    if ($parts[0] === 'Core') {

        aConsole::$console->log('Looking in core') ;
        if ($classname == 'Core\Router') {
            $path = '/core/Core/Router.php' ;
        } else if ($classname == 'Core\Control') {
            $path = '/core/Core/Router.php' ;
        }
        if (isset($path)) {
            aConsole::$console->log('found a path ' . $path) ;

        }

    }

}
