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

}