<?php

Namespace Core;

class BootStrap {

    private static $exitCode ;

    public static function setExitCode($exitCode){
        self::$exitCode = $exitCode ;
    }

    public static function getExitCode(){
        return (is_null(self::$exitCode)) ? 0 : self::$exitCode ;
    }

    public function main($argv_or_boot_params_null) {
        $routeObject = new \Core\Router();
        $route = $routeObject->run($argv_or_boot_params_null);
        $emptyPageVars = array("messages"=>array(), "route"=>$route);
//        \ISOPHP\js_core::$console->log($route, $emptyPageVars) ;
        $this->executeControl($route["control"], $emptyPageVars);
    }

    public function executeControl($controlToExecute, $pageVars=null) {
//        \ISOPHP\js_core::$console->log('control class loading') ;
        $control = new \Core\Control();
//        \ISOPHP\js_core::$console->log('control class loaded', $control) ;
        $controlResult = $control->executeControl($controlToExecute, $pageVars);
//        \ISOPHP\js_core::$console->log('control res 1', $controlResult) ;
        if ($controlResult->type == "view") {
            $viewClass = '\View\\'.$controlResult->view_control.'View' ;
//            \ISOPHP\js_core::$console->log('View Class Name Is:', $viewClass) ;
            $view =  new $viewClass() ;
            $view->executeView($controlResult->view_control, $controlResult->view, $controlResult->page);
        }
        else if ($controlResult->type == "control") {
//            \ISOPHP\js_core::$console->log('control res 2', $controlResult) ;
            $this->executeControl( $controlResult->control, $controlResult->page );
        }
    }

}