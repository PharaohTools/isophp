<?php

require_once(__DIR__.DIRECTORY_SEPARATOR.'default.php') ;
$variables['vmname'] = $variables['application_slug'] ;
$variables['domain'] = $variables['vmname'].'.vm' ;
$variables['desktop_app_slug'] = $variables['vmname'] ;
$variables['android_shell_script'] = 'vm-android-shell.bash' ;
# Developer build (Virtual Machine) can use a back end of either local (VM) or devcloud
if (isset($params['mobilebackend'])) {
    $variables['mobilebackend'] = $params['mobilebackend'] ;
}
else {
    $variables['mobilebackend'] = 'local' ;
}
//var_dump('vm vars', __DIR__.DIRECTORY_SEPARATOR.'default.php', $variables) ;

