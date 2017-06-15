<?php

Namespace Model\LandingPage ;

class PageModel extends \Model\Base {

    public function getPage() {
        $page = array() ;
        $page['title'] = 'A title for a Landing Page' ;
        $page['heading'] = 'A heading for an Landing page' ;
        \ISOPHP\js_core::$console->log('Landing Page Mod', $page) ;
        return $page ;
    }

    public static function bindButtons() {
        return function () {
            \ISOPHP\js_core::$console->log('Binding buttons') ;
            $jQuery = \ISOPHP\js_core::$jQuery ;
            $go_landing_page = $jQuery('#go-index-page') ;
            $go_landing_page->on('click', function () {
                $navigate = new \Model\Navigate() ;
                $navigate->route('Index', 'index') ;
            }) ;
        } ;
    }

}