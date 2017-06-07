<?php

Namespace Core;

class View {

    public function executeView($view, Array $viewVars) {
        $ep = (isset($viewVars["route"]["extraParams"])) ? $viewVars["route"]["extraParams"] : array() ;
        $baseMod = new \Model\Base($ep) ;
        $viewVars["params"] = $baseMod->params ;
        $viewVars = $this->outFormOverrideParam($viewVars);
        $vvLayoutCond1 = (isset($viewVars["params"]["output-format"])
            && $viewVars["params"]["output-format"] == "HTML") ;
        $vvLayoutCond2 = (isset($viewVars["params"]["output-format"])
            && $viewVars["params"]["output-format"] != "cli"
            && $viewVars["params"]["output-format"] != "HTML") ;
        if (!isset($viewVars["layout"])) {
            if ($vvLayoutCond1) { $viewVars["layout"] = "DefaultHTML" ; }
            else if ($vvLayoutCond2) { $viewVars["layout"] = "blank" ; }
            else { $viewVars["layout"] = "blank" ; } }
        $templateData = $this->loadTemplate ($view, $viewVars) ;
        $this->renderAll($templateData) ;
    }

    public function loadTemplate ($view, Array $pageVars) {
        $viewFileName = \ISOPHP\core::$php->ucfirst($view)  ;
        $lvf = $this->loadViewFile($viewFileName, $pageVars) ;
        \ISOPHP\js_core::$console->log('Template loaded', $lvf) ;
        if ($lvf !== false) {
            return $lvf; }
        else {
            // @todo no! dont die
            die ("View Template $viewFileName Not Found\n"); }
    }

    private function renderAll($processedData) {
        echo $processedData;
    }

    public function loadViewFile($viewFileName, $pageVars, $templateData=null) {
        \ISOPHP\js_core::$console->log('ViewFN', $viewFileName) ;
        \ISOPHP\js_core::$console->log('View', $pageVars) ;
        $data['one'] = "ab" ;
        $data['two'] = "cd" ;
        require_once ('/app/Index/View/web/Index.phptpl') ;
        # instead of require, can we do an ajax load, then an eval, or js echo or eval?
        return $data ;
    }

}