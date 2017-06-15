<?php

Namespace Model\Index ;

class PageModel extends \Model\Base {

    public function getPage() {
        $page = array() ;
        $page['title'] = 'A title for an index page' ;
        $page['heading'] = 'A heading for an index page' ;
        \ISOPHP\js_core::$console->log('Ind Page Mod', $page) ;
        return $page ;
    }

    public static function bindButtons() {
        return function () {
            \ISOPHP\js_core::$console->log('Binding buttons') ;
            $jQuery = \ISOPHP\js_core::$jQuery ;
            $go_landing_page = $jQuery('#go-landing-page') ;
            $go_landing_page->on('click', function () {
                $navigate = new \Model\Navigate() ;
                $navigate->route('LandingPage', 'show') ;
            }) ;
        } ;
    }

}