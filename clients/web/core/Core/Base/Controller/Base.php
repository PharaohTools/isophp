<?php

Namespace Controller ;

//@todo each app should have a base controller in required that has a base execute function, then we can just call parent
// in each module controller instead of the thismodel everywhere in each module controller.
class Base {

  public $content;
  protected $registeredModels = array();

  public function __construct() {
    $this->content = array();
  }

  public function execute($pageVars) {
    $defaultExecution = $this->defaultExecution($pageVars) ;
    if (is_array($defaultExecution)) { return $defaultExecution ; }
  }

  protected function defaultExecution($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
      $isDefaultAction = self::checkDefaultActions($pageVars, array(), $thisModel) ;
      if ( is_array($isDefaultAction) ) { return $isDefaultAction; }
      return null ;
  }

  protected function executeMyRegisteredModels($params = null) {
    foreach ($this->registeredModels as $modelClassNameOrArray) {
      if ( is_array($modelClassNameOrArray) ) {
        $currentKeys = array_keys($modelClassNameOrArray) ;
        $currentKey = $currentKeys[0] ;
        $fullClassName = '\Model\\'.$currentKey;}
      else {
        $fullClassName = '\Model\\'.$modelClassNameOrArray; }
      $currentModelFactory = new $fullClassName();
      $currentModel = new $currentModelFactory->getModel($params);
      $miniRay = array();
      $miniRay["appName"] = $currentModel->programNameInstaller;
      $miniRay["installResult"] = $currentModel->askInstall();
      $this->content["results"][] = $miniRay ; }
  }

  protected function getModelAndCheckDependencies($module, $pageVars, $moduleType="Default") {
        $myInfo = \Core\AutoLoader::getSingleInfoObject($module);
        $myModuleAndDependencies = array_merge(array($module), $myInfo->dependencies() ) ;
        $dependencyCheck = $this->checkForRegisteredModels($pageVars["route"]["extraParams"], $myModuleAndDependencies) ;
        if ($dependencyCheck === true) {
            $thisModel = \Model\SystemDetectionFactory::getCompatibleModel($module, $moduleType, $pageVars["route"]["extraParams"]);
            return $thisModel; }
        return $dependencyCheck ;
  }

  protected function failDependencies($pageVars, $content, $errors) {
        $this->content = array_merge($pageVars, $content) ;
        foreach($errors as $error) { $this->content["messages"][] = $error ; }
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);
  }

}