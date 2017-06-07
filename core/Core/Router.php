<?php

Namespace Core;

class Router {

    private	$bootstrapParams;
    private	$route;
    private $availableRoutes = array() ;

//    public function run($bootstrapParams) {
//      \ISOPHP\js_core::$console->log('route is:', $this->route, "bs", $bootstrapParams) ;
//      return $this->route ;
//    }

    public function run($bootstrapParams) {
        $this->bootstrapParams = $bootstrapParams;
        $this->setCurrentRoute();
        \ISOPHP\js_core::$console->log('route is:', $this->route) ;
        return $this->route ;
    }

    private function setCurrentRoute() {
        $this->getAvailableRoutes();
//        $defaultRoute = $this->getDefaultRoute();
        $this->parseControllerAliases();
        $this->setRouteController();
//        if ($this->route != $defaultRoute ) {
//            $this->setRouteAction();
//            $this->setRouteExtraParams(); }
    }

    private function getAvailableRoutes() {
//      $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
//      $all_processed_arrays = array();
//      foreach ($allInfoObjects as $infoObject) {
//        $curKeys = array_keys($infoObject->routesAvailable());
//        $routesAvailable = $infoObject->routesAvailable();
//        foreach ($curKeys as $curKey) {
//          if (isset($all_processed_arrays[$curKey]) ) {
//            $curValues = $all_processed_arrays[$curKey];
//            $all_processed_arrays[$curKey] = array_merge($curValues, $routesAvailable[$curKey] ); }
//          else {
//            $all_processed_arrays[$curKey] = $routesAvailable[$curKey]; } } }
      $this->availableRoutes = array("Index" => array("index"));
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
        if (isset($this->bootstrapParams[1])) {
            if (\ISOPHP\core::$php->array_key_exists( $this->bootstrapParams[1], $this->availableRoutes )) {
                $this->route["control"] = $this->bootstrapParams[1] ;
            } else {
                $this->route["control"] = $this->route = $this->getDefaultRoute();
            }
        }
        else {
            $this->route["control"] = $this->route = $this->getDefaultRoute();
        }

    }

    private function setRouteAction() {
        $actionSet = isset($this->bootstrapParams[2]) ;
        if ($actionSet) {
            $correctAct = \ISOPHP\core::$php->in_array( $this->bootstrapParams[2], $this->availableRoutes[$this->bootstrapParams[1]] ) ;
        } else {
            $correctAct = false ;
        }
        if ($actionSet && $correctAct) {
            $this->route["action"] = $this->bootstrapParams[2] ;
        } else {
            $this->route["action"] = $this->route = $this->getDefaultRoute();
        }
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