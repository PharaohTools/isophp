<?php

//$pipe_dir = __DIR__.DIRECTORY_SEPARATOR."build/ptbuild/pipes" ;
$pipe_dir = "build/ptbuild/pipes" ;
$pipe_files = getDirContents($pipe_dir) ;

$other_files = array(
//    "build/ptbuild/pipes/build_development_application/defaults",
//    "build/ptbuild/pipes/build_development_application/settings",
//    "build/ptbuild/pipes/build_development_application/steps",
    "build/ptbuild/ptbuildvars",
    "build/android-shell.bash",
    "build/cloud-android-shell.bash",
    "build/vm-android-shell.bash",
//    "build/ptc/all-vm-web-assets.dsl.php", # Intentionally leave this
    "build/ptc/build-desktop-application.dsl.php",
    "build/ptc/build-machine-osx.dsl.php",
    "build/ptc/build-mobile-application.dsl.php",
    "build/ptc/build-web-client-application.dsl.php",
    "build/ptc/build-web-server-application.dsl.php",
    "build/ptc/cloud-mobile-build.dsl.php",
    "build/ptc/config-build-server.dsl.php",
    "build/ptc/development.dsl.php",
    "build/ptc/dev-host.dsl.php",
    "build/ptc/socket-server-restart.dsl.php",
    "build/ptc/virtual-machine.dsl.php",
    "clients/desktop/app.js",
    "clients/desktop/fs.js",
    "clients/mobile/config.xml",
    "clients/mobile/app.js",
    "clients/mobile/fs.js",
    "clients/mobile/www/js/index.js",
    "clients/web/app.js",
    "clients/web/fs.js",
    "core/Core/Control.php",
    "core/Core/Router.php",
    "core/Core/View.php",
    "core/Core/Base/Controller/Base.php",
    "core/Core/Base/Controller/Result.php",
    "core/Core/Base/Info/Base.php",
    "core/Core/Base/Model/Base.php",
    "core/Core/Base/Model/Navigate.php",
    "core/Core/Base/Model/RegistryStore.php",
    'core/bootstrap.php',
    'core/electron.fephp',
    'core/index.php',
    'core/init.php',
    'core/isophp.php',
    'core/WindowMessage.php',
    "vars/configuration_devcloud.php",
    "vars/configuration_local.php",
    "vars/configuration_production.php",
    "vars/configuration_staging.php",
//    "vars/default.php", Intentionally leave this, update it manually
    "vars/production.php",
    "vars/staging.php",
    "vars/vm.php",
    "update-framework.php",
//    "Virtufile",
) ;

$files_to_update = array_merge($pipe_files, $other_files) ;


if ( isset($argv[1]) && ($argv[1] != '' || $argv[1] != false) ) {
    $isophp_home = $argv[1] ;
} else {
    echo "ISO PHP Home Dir should be first parameter to this script\n" ;
    exit (1) ;
}

if ( isset($argv[2]) && ($argv[2] == 'to' || $argv[2] == 'from') ) {
    $to_from = $argv[2] ;

} else {
    echo "to or from must be the second parameter to this script\n" ;
    exit (1) ;
}

$isophp_example_application_home = getcwd().DIRECTORY_SEPARATOR ;

foreach ($files_to_update as $file_to_update) {

    if ($to_from === 'to') {
        $dir = dirname($isophp_home.$file_to_update) ;
        if (!is_dir($dir)) mkdir($dir, 0755, true) ;
        $comm = "cp {$isophp_example_application_home}{$file_to_update} {$isophp_home}{$file_to_update}" ;
    } else {
        $dir = dirname($isophp_example_application_home.$file_to_update) ;
        if (!is_dir($dir)) mkdir($dir, 0755, true) ;
        $comm = "cp {$isophp_home}{$file_to_update} {$isophp_example_application_home}{$file_to_update}" ;
    }

    if ( isset($argv[3]) && ($argv[3] == 'run') ) {
        echo "run parameter included, performing commands for real\n" ;
        system($comm) ;
    } else {
        if (!isset($runny)) {
            echo "run parameter not included, just echoing what I would have run...\n" ;
            $runny = true ;
        }
        echo "{$comm}\n" ;
    }

}

function getDirContents($path) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    $files = array();
    foreach ($rii as $file)
        if (!$file->isDir())
            $files[] = $file->getPathname();

    return $files;
}

//function recursive_copy($source, $dest) {
////    $source = "dir/dir/dir";
////    $dest= "dest/dir";
//
//    mkdir($dest, 0755);
//    foreach (
//        $iterator = new \RecursiveIteratorIterator(
//            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
//            \RecursiveIteratorIterator::SELF_FIRST) as $item
//    ) {
//        if ($item->isDir()) {
//            mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
//        } else {
//            copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
//        }
//    }
//}