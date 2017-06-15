<?php

Namespace View ;

class LandingPageView extends \Core\View {

    public function display($data) {
//        \ISOPHP\js_core::$console->log('data', $data ) ;
        $jQuery =  \ISOPHP\js_core::$jQuery ;
        \ISOPHP\js_core::$window->document->title = 'Landing Page' ;
        $tplfunc = \Core\View::$template ;
        $tpl_data = $tplfunc() ;
//        \ISOPHP\js_core::$console->log('davey ravey don', $tpl_data) ;
        $jQuery('#template')->html($tpl_data) ;
        $jQuery('.app-loader')->css('display', 'none') ;
    }

}