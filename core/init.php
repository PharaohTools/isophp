<?php

\ISOPHP\core::$php = $php ;
\ISOPHP\core::$file_index = $file_index ;
\ISOPHP\js_core::$console = $console ;
\ISOPHP\js_core::$window = $window ;
\ISOPHP\js_core::$jQuery = $jQuery ;

if (CURRENT_TARGET === 'desktop') {

    $console->log("desktop init") ;
    $electron_app = $window->require('electron')->remote ;
    \ISOPHP\electron::$BrowserWindow = $electron_app ;

    \ISOPHP\js_core::$window->document->onreadystatechange = function () use ($electron_app) {
        if (\ISOPHP\js_core::$window->document->readyState === "complete") {
            \ISOPHP\electron::application_controls($electron_app);
        }
    } ;

}

function __autoload($classname) {
    \ISOPHP\js_core::$console->log("Autoloading " . $classname) ;
    if ($classname === 'ISOPHP\core') {
        return ;
    } else if ($classname === 'ISOPHP\js_core') {
        return ;
    } else if ($classname === 'Controller\Base') {
        $path = '/core/Core/Base/Controller/Base.fephp' ;
        require_once ($path) ;
        return ;
    } else if ($classname === 'Controller\Result') {
        $path = '/core/Core/Base/Controller/Result.fephp' ;
        require_once ($path) ;
        return ;
    } else if ($classname === 'Model\Base') {
        $path = '/core/Core/Base/Model/Base.fephp' ;
        require_once ($path) ;
        return ;
    } else if ($classname === 'Info\Base') {
        $path = '/core/Core/Base/Info/Base.fephp' ;
        require_once ($path) ;
        return ;
    } else if ($classname === 'stdClass') {
        return ;
    }
    $parts = \ISOPHP\core::$php->explode('\\', $classname) ;
    \ISOPHP\js_core::$console->log($parts) ;
    if ($parts[0] === 'Core') {
        \ISOPHP\js_core::$console->log('Looking in core') ;
        if ($classname == 'Core\Router') {
            $path = '/core/Core/Router.fephp' ;
        } else if ($classname == 'Core\Control') {
            $path = '/core/Core/Control.fephp' ;
        } else if ($classname == 'Core\View') {
            $path = '/core/Core/View.fephp' ;
        }
        if (isset($path)) {
            \ISOPHP\js_core::$console->log('found a path ' . $path) ;
            require_once ($path) ;
        }
    }
    else if ($parts[0] === 'Controller') {
        \ISOPHP\js_core::$console->log('Looking in Controller') ;
        $module = \ISOPHP\core::$php->str_replace('Controller', '', $parts[1]) ;
        $path = '/app/'.$module.'/Controller/'.$parts[1].'.fephp' ;
        if (isset($path)) {
            \ISOPHP\js_core::$console->log('found a controller path ' . $path) ;
            require_once ($path) ;
        }
    }
    else if ($parts[0] === 'Model') {
        \ISOPHP\js_core::$console->log('Looking in Model') ;
        $module = \ISOPHP\core::$php->str_replace('Model', '', $parts[1]) ;
        $path = '/app/'.$module.'/Model/'.$parts[1].$parts[2].'.fephp' ;
        if (isset($path)) {
            \ISOPHP\js_core::$console->log('found a model path ' . $path) ;
            require_once ($path) ;
        }
    }
    else if ($parts[0] === 'View') {
        \ISOPHP\js_core::$console->log('Looking in View') ;
        $module = \ISOPHP\core::$php->str_replace('View', '', $parts[1]) ;
        $path = '/app/'.$module.'/View/'.$parts[1].'.fephp' ;
        if (isset($path)) {
            \ISOPHP\js_core::$console->log('found a view path ' . $path) ;
            require_once ($path) ;
        }
    }

}
