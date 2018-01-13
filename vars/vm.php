<?php

require(__DIR__.DIRECTORY_SEPARATOR.'default.php') ;
$variables['vmname'] = $variables['application_slug'] ;
$variables['domain'] = $variables['vmname'].'.vm' ;
$variables['desktop_app_slug'] = $variables['vmname'] ;
$variables['android_shell_script'] = 'vm-android-shell.bash' ;

if (isset($params['backendenv'])) {
    $variables['backendenv'] = $params['backendenv'] ;
    if (in_array($params['backendenv'], array('local', 'devcloud'))) {
        $variables['custom_branch'] = 'development' ;
    }
} else {
    $params['backendenv'] = 'local' ;
    $variables['backendenv'] = $params['backendenv'] ;
}

# Developer build (Virtual Machine) can use a back end of either local (VM) or devcloud
//var_dump('vm vars', __DIR__.DIRECTORY_SEPARATOR.'default.php', $variables) ;

