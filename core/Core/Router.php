<?php

Namespace Core;

class Router {

    private	$bootstrapParams;
    private	$route;
    private $availableRoutes = array() ;

    public function run($bootstrapParams) {

        // \ISOPHP\js_core::$console->log('Running router with the following') ;
        // \ISOPHP\js_core::$console->log($bootstrapParams) ;

        $this->bootstrapParams = $bootstrapParams;
        $this->setCurrentRoute();
        // \ISOPHP\js_core::$console->log('route is:', $this->route) ;
        return $this->route ;
    }

    private function setCurrentRoute() {
        $this->getAvailableRoutes();
        // \ISOPHP\js_core::$console->log('Router 1') ;
        $this->parseControllerAliases();
        // \ISOPHP\js_core::$console->log('Router 2') ;
        $this->setRouteController();
        // \ISOPHP\js_core::$console->log('Router 3') ;
        $this->setRouteAction();
        // \ISOPHP\js_core::$console->log('Router 4') ;
        $this->setRouteExtraParams();
        // \ISOPHP\js_core::$console->log('Router 5') ;
    }

    private function getAvailableRoutes() {
      $this->availableRoutes = array(
          "Index" => array("index"),
      );
    }

    private function getDefaultRoute() {
      $this->setDefaultRouteExtraParams() ;
      return array( "control" => "Index" , "action" => "index", "extraParams" => $this->route["extraParams"] );
    }

    private function parseControllerAliases() {
//      $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
      $aliases = array();
//      foreach ($allInfoObjects as $infoObject) {
//        $aliases = array_merge( $aliases, $infoObject->routeAliases() ); }
      if (isset($this->bootstrapParams[1])) {
        if (\ISOPHP\core::$php->array_key_exists($this->bootstrapParams[1], $aliases)) {
          $this->bootstrapParams[1] = strtr($this->bootstrapParams[1], $aliases); } }
    }

    private function setRouteController() {

        // \ISOPHP\js_core::$console->log('BSP 1', $this->bootstrapParams[1]) ;
        if (isset($this->bootstrapParams[1])) {
            // \ISOPHP\js_core::$console->log('AKE 1',  $this->availableRoutes ) ;
            // \ISOPHP\js_core::$console->log('AKE 2',  $this->availableRoutes, \ISOPHP\core::$php->array_key_exists( $this->bootstrapParams[1], $this->availableRoutes )) ;
            if (\ISOPHP\core::$php->array_key_exists( $this->bootstrapParams[1], $this->availableRoutes )) {
                $this->route["control"] = $this->bootstrapParams[1] ;
            } else {
                $this->route = $this->getDefaultRoute();
            }
        }
        else {
            $this->route = $this->getDefaultRoute();
        }

    }

    private function setRouteAction() {
        $actionSet = isset($this->bootstrapParams[2]) ;
        // \ISOPHP\js_core::$console->log('SRA 1', $actionSet) ;
        if ($actionSet) {
            // \ISOPHP\js_core::$console->log('SRA 6', $this->bootstrapParams[2], $this->bootstrapParams[1],  $this->availableRoutes[$this->bootstrapParams[1]]) ;
            $correctAct = \ISOPHP\core::$php->in_array( $this->bootstrapParams[2], $this->availableRoutes[$this->bootstrapParams[1]] ) ;
        } else {
            $correctAct = false ;
        }
        // \ISOPHP\js_core::$console->log('SRA 2', $correctAct) ;
        if ($actionSet == true && $correctAct == true) {
            $this->route["action"] = $this->bootstrapParams[2] ;
            // \ISOPHP\js_core::$console->log('SRA 4', $this->route["action"]) ;
        }
        if ($actionSet !== true) {
            $this->route["action"] = $this->getDefaultRoute() ;
            // \ISOPHP\js_core::$console->log('SRA 5', $this->route["action"]) ;
        }
        if ($correctAct !== true) {
            $this->route["action"] = $this->getDefaultRoute() ;
            // \ISOPHP\js_core::$console->log('SRA 5', $this->route["action"]) ;
        }
        // \ISOPHP\js_core::$console->log('SRA 3', $this->route["action"]) ;
    }

    private function setRouteExtraParams() {
        $this->route["extraParams"] = array();
        $numberOfExtraParams = \ISOPHP\core::$php->count($this->bootstrapParams)-3;
        for ($i=3; $i<($numberOfExtraParams+3); $i++) {
            $this->route["extraParams"][] = $this->bootstrapParams[$i] ;}
    }

    private function setDefaultRouteExtraParams() {
        $this->route["extraParams"] = array();
        $numberOfExtraParams = \ISOPHP\core::$php->count($this->bootstrapParams)-1;
        for ($i=1; $i<($numberOfExtraParams+1); $i++) {
            $this->route["extraParams"][] = $this->bootstrapParams[$i] ;}
    }

}