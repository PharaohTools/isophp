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

    public function main($argv_or_boot_params_null, $params) {
        // \ISOPHP\js_core::$console->log('bootstrap main', $argv_or_boot_params_null, $params) ;
        $routeObject = new \Core\Router();
        $route = $routeObject->run($argv_or_boot_params_null);
        $startPageVars = array("messages"=>array(), "route"=>$route, "params" => $params);
        // \ISOPHP\js_core::$console->log('current route is', $route, $startPageVars) ;
        $this->executeControl($route["control"], $startPageVars);
    }

    public function executeControl($controlToExecute, $pageVars) {
        \ISOPHP\js_core::$console->log('control class loading') ;
        $control = new \Core\Control();
        \ISOPHP\js_core::$console->log('control class loaded', $control, "pvars are", $pageVars) ;
        $controlResult = $control->executeControl($controlToExecute, $pageVars);
        \ISOPHP\js_core::$console->log('control res 1', $controlResult) ;
        if ($controlResult->type == "view") {
            $viewClass = '\View\\'.$controlResult->view_control.'View' ;
            \ISOPHP\js_core::$console->log('View Class Name Is:', $viewClass) ;
            $view =  new $viewClass() ;

            // flush the template of the view, i think it breaks susequent loads
            \Core\View::$template = null ;

            $view->executeView($controlResult->view_control, $controlResult->view, $controlResult->page);
            if (isset($controlResult->post_template)) {
                \ISOPHP\js_core::$console->log('post template is set', $controlResult->post_template) ;
                foreach ($controlResult->post_template as $post_template_method) {
                    $post_template_method() ;
                }
                $controlResult->post_template = null ;
            }
        }
        else if ($controlResult->type == "control") {
            \ISOPHP\js_core::$console->log('control res 2', $controlResult) ;
            $this->executeControl( $controlResult->control, $controlResult->page );
        }
    }

}