<?php

Namespace Core;

use ISOPHP\core;

class View {

    public static $page_vars ;
    public static $view_file_name ;
    public static $template ;

    public function executeView($module, $view, Array $viewVars) {
        $ep = (isset($viewVars["route"]["extraParams"])) ? $viewVars["route"]["extraParams"] : array() ;
        $baseMod = new \Model\Base($ep) ;
        $viewVars["params"] = $baseMod->params ;
        $vvLayoutCond1 = (isset($viewVars["params"]["output-format"])
            && $viewVars["params"]["output-format"] == "HTML") ;
        $vvLayoutCond2 = (isset($viewVars["params"]["output-format"])
            && $viewVars["params"]["output-format"] != "cli"
            && $viewVars["params"]["output-format"] != "HTML") ;
        if (!isset($viewVars["layout"])) {
            if ($vvLayoutCond1) { $viewVars["layout"] = "DefaultHTML" ; }
            else if ($vvLayoutCond2) { $viewVars["layout"] = "blank" ; }
            else { $viewVars["layout"] = "blank" ; } }
        $templateData = $this->loadTemplate ($module, $view, $viewVars) ;
        $this->display($templateData) ;
    }

    protected function display($templateData) {
        \ISOPHP\js_core::$console->log('Default Display Method', $templateData) ;
    }

    public function loadTemplate ($module, $view, Array $pageVars) {
        $viewFileName = \ISOPHP\core::$php->ucfirst($view)  ;
        $lvf = $this->loadViewFile($module, $viewFileName, $pageVars) ;
        \ISOPHP\js_core::$console->log('Template loaded', $lvf) ;
        if ($lvf !== false) {
            return $lvf; }
        else {
            // @todo no! dont die
            die ("View Template $viewFileName in module $module Not Found\n"); }
    }

    public function loadViewFile($module, $viewFileName, $pageVars, $templateData=null) {
        \ISOPHP\js_core::$console->log('ViewFN', $viewFileName) ;
        self::$view_file_name = $viewFileName;
         \ISOPHP\js_core::$console->log('View PageVars', $pageVars, $module, \ISOPHP\js_core::$window->location->hostname) ;
        self::$page_vars = $pageVars;

        $view_client_path = '/app/'.$module.'/View/'.CURRENT_TARGET.'/'.$viewFileName ;
        $view_default_path = '/app/'.$module.'/View/'.$viewFileName ;

        if ($this->templateExists($view_client_path) === true) {
            include($view_client_path) ;
            return true ;
        } else if ($this->templateExists($view_default_path) === true) {
            include($view_default_path) ;
            return true ;
        } else {
            \ISOPHP\js_core::$console->log("Unable to find view template $view_client_path or default $view_default_path") ;
            return false ;
        }
    }

    public function templateExists($path) {
        $php = \ISOPHP\core::$php ;
        if ($php->in_array($path, \ISOPHP\core::$file_index)){
            return true ;
        }
        if ($php->substr($path, 0, 1) === '/') {
            $noprefix = $php->substr($path, 1) ;
            if ($php->in_array($noprefix, \ISOPHP\core::$file_index)){
                return true ;
            }
        }
        return false ;
    }

}