<?php
include (__DIR__.DIRECTORY_SEPARATOR.'default.php') ;
$variables['vmname'] = $variables['application_slug'] ;
$variables['domain'] = $variables['vmname'].'.vm' ;
$variables['desktop_app_slug'] = $variables['vmname'] ;
$variables['android_shell_script'] = 'vm-android-shell.bash' ;
# Developer build can use a baack end of either
$variables['mobilebackend'] = $params['mobilebackend'] ;

