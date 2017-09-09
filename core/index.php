<?php

$console = new \ISOPHP\console();

$console->log('In the applications index file') ;
$console->log($_REQUEST, $_SERVER) ;

$route_set = array() ;

if (ISOPHP_EXECUTION_ENVIRONMENT === 'ZEND') {
    $raw_path_one = $_SERVER['REQUEST_URI'];
} else {
    $raw_path_one = \ISOPHP\js_core::$window->location->pathname ;
}

$raw_path = substr($raw_path_one, 1) ;
$parts = \ISOPHP\core::$php->explode('/', $raw_path) ;

$_REQUEST['control'] = \ISOPHP\core::$php->ucfirst($parts[0]) ;

if (isset($parts[0]) && !isset($parts[1])) {
    $_REQUEST['action'] = "show" ;
} else {
    $_REQUEST['action'] = $parts[1] ;
}
$route_set[] = isset($_REQUEST['control']) ;
$route_set[] = isset($_REQUEST['action']) ;

if ( \ISOPHP\core::$php->in_array(false, $route_set) ) {
    $_REQUEST['control'] = "Index" ;
    $_REQUEST['action'] = "index" ; }

if (!isset($_REQUEST['output-format'])) {
    $_REQUEST['output-format'] = "HTML"; }

$cleo_vars = array();
$cleo_vars[0] = __FILE__;
$cleo_vars[1] = $_REQUEST['control'];
$cleo_vars[2] = $_REQUEST['action'];
foreach($_REQUEST as $post_key => $post_var) {
    if (!\ISOPHP\core::$php->in_array($post_key, array('control', 'action'))) {
        $cleo_vars[] = "--$post_key=$_REQUEST[$post_key]" ; } }
$_ENV['bootstrap'] = \ISOPHP\core::$php->serialize($cleo_vars);

$console->log($cleo_vars, $_ENV) ;

$bootStrap = new \Core\BootStrap();
\ISOPHP\core::$bootstrap = $bootStrap ;
$argv_or_null = (isset($argv)) ? $argv : null ;
$bootStrapParams = (isset($_ENV['bootstrap'])) ? \ISOPHP\core::$php->unserialize($_ENV['bootstrap']) : $argv_or_null ;
\ISOPHP\core::$bootstrap->main($bootStrapParams, array());
