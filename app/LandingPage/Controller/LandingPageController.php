<?php

Namespace Controller ;

class LandingPageController extends \Controller\Base {

    public function execute($pageVars) {
        $page_model = new \Model\LandingPage\PageModel() ;
        $page = $page_model->getPage() ;
        \ISOPHP\js_core::$console->log('ICP', $page) ;
        $res = new \Controller\Result() ;
        $res->page = $page ;
        $res->view = 'LandingPage.phptpl' ;
        $res->type = 'view' ;
        $res->view_control = 'LandingPage' ;
        $res->post_template[] = $page_model->bindButtons() ;
        \ISOPHP\js_core::$console->log('LandingPage Con', $res) ;
        return $res ;
    }

}