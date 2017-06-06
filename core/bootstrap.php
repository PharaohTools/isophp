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
        $this->executeControl($route["control"], $emptyPageVars);
    }

    public function executeControl($controlToExecute, $pageVars=null) {
        $control = new \Core\Control();
        $controlResult = $control->executeControl($controlToExecute, $pageVars);
        if ($controlResult["type"]=="view") {
            $this->executeView( $controlResult["view"], $controlResult["pageVars"] ); }
        else if ($controlResult["type"]=="control") {
            $this->executeControl( $controlResult["control"], $controlResult["pageVars"] ); }
        else {
            $exception = new \Exception( 'No controller result type specified', 0);
            $exception->run() ;
        }
    }

    private function executeView($viewTemplate, $viewVars) {
        $view = new \Core\View();
        $view->executeView($viewTemplate, $viewVars);
    }


}