<?php

Namespace Controller ;

class IndexController extends \Controller\Base {

    public function execute($pageVars) {
        $page_model = new \Model\Index\PageModel() ;
        $res['page'] = $page_model->getPage() ;
        return $res ;
    }

}