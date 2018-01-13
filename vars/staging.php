<?php
include (__DIR__.DIRECTORY_SEPARATOR.'default.php') ;
$variables['vmname'] = $variables['application_slug'] ;
$variables['domain'] = $variables['vmname'].'.vm' ;
$variables['desktop_app_slug'] = $variables['vmname'] ;


$variables['backendenv'] = 'staging' ;
$variables['custom_branch'] = $variables['backendenv'] ;