<?php

\ISOPHP\core::$registry = new \Model\RegistryStore();
\ISOPHP\core::$data_ray = array() ;
if (isset($console)) {
    \ISOPHP\js_core::$console = $console ;
}
if (isset($window)) {
    \ISOPHP\js_core::$window = $window ;
}
if (isset($jQuery)) {
    \ISOPHP\js_core::$jQuery = $jQuery ;
}

if (\ISOPHP\core::$php == NULL) {
    define('ISOPHP_EXECUTION_ENVIRONMENT', 'ZEND') ;
    \ISOPHP\core::$php = new \ISOPHP\PHPWrapper() ;
    \ISOPHP\core::$php->error_log("This is running in Zend ") ;
} else {
    define('ISOPHP_EXECUTION_ENVIRONMENT', 'UNITER') ;
}

if (\ISOPHP\js_core::$console == NULL) {
    \ISOPHP\js_core::$console = new \ISOPHP\console() ;
}

if (\ISOPHP\core::$file_index == NULL) {
    $iso_php = new \ISOPHP\core() ;
    \ISOPHP\core::$file_index = $iso_php->load_file_index();
}

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
    if ($classname === 'ISOPHP\core') {
        return ;
    } else if ($classname === 'ISOPHP\js_core') {
        return ;
    } else if ($classname === 'Controller\Base') {
        $path = '/core/Core/Base/Controller/Base.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'Controller\Result') {
        $path = '/core/Core/Base/Controller/Result.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'Model\Base') {
        $path = '/core/Core/Base/Model/Base.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'Model\Configuration') {
        $path = '/core/app_vars.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'Model\Navigate') {
        $path = '/core/Core/Base/Model/Navigate.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'Model\RegistryStore') {
        $path = '/core/Core/Base/Model/RegistryStore.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'Info\Base') {
        $path = '/core/Core/Base/Info/Base.fephp' ;
        require_once (REQUIRE_PREFIX.$path) ;
        return ;
    } else if ($classname === 'stdClass') {
        return ;
    }
    // \ISOPHP\core::$php->error_log("Autoloading " . $classname) ;
    $parts = \ISOPHP\core::$php->explode('\\', $classname) ;
    if ($parts[0] === 'Core') {
            // \ISOPHP\core::$php->error_log('Looking in core') ;
        if ($classname == 'Core\Router') {
            $path = '/core/Core/Router.fephp' ;
        } else if ($classname == 'Core\Control') {
            $path = '/core/Core/Control.fephp' ;
        } else if ($classname == 'Core\View') {
            $path = '/core/Core/View.fephp' ;
        }
        if (isset($path)) {
            // \ISOPHP\core::$php->error_log('found a path ' . $path) ;
            require_once (REQUIRE_PREFIX.$path) ;
        }
    }

    if ($parts[0] === 'Controller') {
        // \ISOPHP\core::$php->error_log('Looking in Controller') ;
        $module = \ISOPHP\core::$php->str_replace('Controller', '', $parts[1]) ;
        $path = '/app/'.$module.'/Controller/'.$parts[1].'.fephp' ;
        if (isset($path)) {
            // \ISOPHP\core::$php->error_log('found a controller path ' . $path) ;
            require_once (REQUIRE_PREFIX.$path) ;
        }
    }
    else if ($parts[0] === 'Model') {
        // \ISOPHP\core::$php->error_log('Looking in Model') ;
        $module = \ISOPHP\core::$php->str_replace('Model', '', $parts[1]) ;
        $path = '/app/'.$module.'/Model/'.$parts[1].$parts[2].'.fephp' ;
        if (isset($path)) {
            // \ISOPHP\core::$php->error_log('found a model path ' . $path) ;
            require_once (REQUIRE_PREFIX.$path) ;
        }
    }
    else if ($parts[0] === 'View') {
        // \ISOPHP\core::$php->error_log('Looking in View') ;
        $module = \ISOPHP\core::$php->str_replace('View', '', $parts[1]) ;
        $path = '/app/'.$module.'/View/'.$parts[1].'.fephp' ;
        if (isset($path)) {
            // \ISOPHP\core::$php->error_log('found a view path ' . $path) ;
            require_once (REQUIRE_PREFIX.$path) ;
        }
    }
}
