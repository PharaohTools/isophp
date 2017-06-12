<?php

Namespace Core;

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
         \ISOPHP\js_core::$console->log('View PageVars', $pageVars,  \ISOPHP\js_core::$window->location->hostname) ;
        self::$page_vars = $pageVars;
        $view_path = '/app/'.$module.'/View/web/'.$viewFileName ;
        $view_data = \ISOPHP\core::$php->file_get_contents($view_path) ;
        include($view_path) ;
        \ISOPHP\js_core::$console->log('View Template Function', self::$template) ;
        # instead of require, can we do an ajax load, then an eval, or js echo or eval?
        return $view_data ;
    }

}