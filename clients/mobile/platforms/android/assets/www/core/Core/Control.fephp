<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {
        \ISOPHP\js_core::$console->log('raw control', $control) ;
        $ucf_control = \ISOPHP\core::$php->ucfirst($control);
        \ISOPHP\js_core::$console->log('ucf control', $ucf_control) ;
        $className = '\\Controller\\' . $ucf_control.'Controller' ;
        $controlObject = new $className;
        return $controlObject->execute($pageVars);
    }

}