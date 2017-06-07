<?php

Namespace Model\Index ;

class PageModel extends \Model\Base {

    public function getPage() {
        $page['title'] = 'A title for an index page' ;
        $page['heading'] = 'A heading for an index page' ;
        return $page ;
    }

}