<?php

Namespace Controller ;

class IndexController extends \Controller\Base {

    public function execute($pageVars) {

        $page_model = new \Model\Index\PageModel() ;
        $page = $page_model->getPage() ;
        \ISOPHP\js_core::$console->log('ICP', $page) ;
        $res = new \Controller\Result() ;
        $res->page = $page ;
        $res->view = 'index.phptpl' ;
        $res->type = 'view' ;
        $res->view_control = 'Index' ;
        \ISOPHP\js_core::$console->log('Ind Con', $res) ;
        return $res ;
    }

}