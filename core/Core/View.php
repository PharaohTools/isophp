<?php

Namespace Core;

class View {

    public static $page_vars ;
    public static $view_file_name ;
    public static $template ;
    public static $server_template ;

    public function executeView($module, $view, Array $viewVars) {
        // \ISOPHP\js_core::$console->log('executing view', $module, $view, $viewVars) ;
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
        // \ISOPHP\js_core::$console->log('loading template', $module, $view, $viewVars) ;
        $templateData = $this->loadTemplate ($module, $view, $viewVars) ;
        $this->display($templateData) ;
    }

    protected function display($templateData) {
        // \ISOPHP\js_core::$console->log('Default Display Method', $templateData) ;
    }

    public function loadTemplate ($module, $view, Array $pageVars) {
        $viewFileName = \ISOPHP\core::$php->ucfirst($view)  ;
        // \ISOPHP\js_core::$console->log('before load template', $module, $view, $pageVars) ;
        $lvf = $this->loadViewFile($module, $viewFileName, $pageVars) ;
        // \ISOPHP\js_core::$console->log('Template loaded', $lvf, $view) ;
        if ($lvf !== false) {
            return $lvf; }
        else {
            // @todo no! dont die
            die ("View Template $viewFileName in module $module Not Found\n"); }
    }

    public function loadViewFile ($module, $viewFileName, $pageVars) {
        \ISOPHP\js_core::$console->log('ViewFN', $viewFileName) ;
        self::$view_file_name = $viewFileName;
        \ISOPHP\js_core::$console->log('View PageVars', $pageVars, $module) ;
        self::$page_vars = $pageVars;

        $view_client_path = '/app/'.$module.'/View/'.CURRENT_TARGET.'/'.$viewFileName ;
        $view_default_path = '/app/'.$module.'/View/'.$viewFileName ;
        \ISOPHP\js_core::$console->log("Current Target is ".CURRENT_TARGET) ;
        \ISOPHP\js_core::$console->log("View Looking for $view_client_path") ;
        \ISOPHP\js_core::$console->log("And looking for $view_default_path") ;

        if ($this->templateExists($view_client_path) === true) {
            include(REQUIRE_PREFIX.$view_client_path) ;
            return true ;
        } else if ($this->templateExists($view_default_path) === true) {
            include(REQUIRE_PREFIX.$view_default_path) ;
            return true ;
        } else {
             \ISOPHP\js_core::$console->log("Unable to find view template $view_client_path or default $view_default_path") ;
            return false ;
        }
    }

    public static function parse_view_template($template) {
        if ($template === null) {
            $template = self::$template ;
        }
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'UNITER') {
            $ft = $template()  ;
            return $ft ;
        }
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
            if ( is_callable($template) ) {
                return call_user_func($template) ;
            }
        }
    }

    public static function execute_view_template($template_element_id, $template_data) {
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'UNITER') {
            $jQuery =  \ISOPHP\js_core::$jQuery ;
            $jQuery('#template')->html($template_data) ;
            $jQuery('.app-loader')->css('display', 'none') ;
        }
        if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
            self::$server_template = $template_data ;
        }
        return true ;
    }

    public function templateExists($path) {
        $php = \ISOPHP\core::$php ;
        $file_index = \ISOPHP\core::$file_index ;
        \ISOPHP\js_core::$console->log('view: file index in templateExists', $file_index) ;
        \ISOPHP\js_core::$console->log($file_index) ;
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