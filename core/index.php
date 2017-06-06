<?php

if ( !isset($_REQUEST['control']) || !isset($_REQUEST['action']) ) {
    // @todo i dont think this requires an echo
    // echo '<p>Control or Action is missing, using default</p>';
    $_REQUEST['control'] = "Index" ;
    $_REQUEST['action'] = "index" ;}
if (!isset($_REQUEST['output-format'])) { $_REQUEST['output-format'] = "HTML"; }
$cleo_vars = array();
$cleo_vars[0] = __FILE__;
$cleo_vars[1] = $_REQUEST['control'];
$cleo_vars[2] = $_REQUEST['action'];
foreach($_REQUEST as $post_key => $post_var) {
    if (!in_array($post_key, array('control', 'action'))) {
        $cleo_vars[] = "--$post_key=$_REQUEST[$post_key]" ; } }
$_ENV['ptbuild_bootstrap'] = serialize($cleo_vars);

$bootStrap = new \Core\BootStrap();
$argv_or_null = (isset($argv)) ? $argv : null ;
$bootStrapParams = (isset($_ENV['bootstrap'])) ? unserialize($_ENV['bootstrap']) : $argv_or_null ;
$bootStrap->main($bootStrapParams);