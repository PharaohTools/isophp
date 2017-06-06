<?php

$target_client = 'web' ;

$core_dir_path = dirname(__DIR__).DIRECTORY_SEPARATOR.'core' ;
$app_dir_path = dirname(__DIR__).DIRECTORY_SEPARATOR.'app' ;
$app_dir_array = array_diff(scandir($app_dir_path), array('.', '..')) ;

$client_root = dirname(__DIR__).DIRECTORY_SEPARATOR."clients".DIRECTORY_SEPARATOR.$target_client.DIRECTORY_SEPARATOR ;
$client_directory = $client_root."app".DIRECTORY_SEPARATOR ;

$available_clients = array('desktop', 'mobile', 'web') ;

echo "\n\n\nRemove Client Application Directory before build {$client_directory}\n" ;
system('rm -rf ' . $client_directory);


foreach ($app_dir_array as $module_name) {
    echo "\n\n\nFound Module {$module_name}\n" ;
    $mod_path = $app_dir_path.DIRECTORY_SEPARATOR.$module_name ;
    $module_contents = array_diff(scandir($mod_path), array('.', '..')) ;
    foreach ($module_contents as $module_root_file_or_dir) {
        $item_path = $mod_path . DIRECTORY_SEPARATOR . $module_root_file_or_dir;
        if (is_file($item_path)) {
            echo "Found File {$item_path}\n";
            $original_file = "$item_path";
            $new_file = $client_directory . $module_name . DIRECTORY_SEPARATOR . $module_root_file_or_dir;
            if (substr($new_file, -4, 4) === '.php') {
                echo "Switching .php to .fephp\n";
                $new_file = str_replace('.php', '.fephp', $new_file);
            }
            copy($original_file, $new_file);
        } else if (is_dir($item_path)) {
            echo "\n\nFound Directory {$item_path}\n";
            if (in_array($module_root_file_or_dir, array("Model", "View", "Controller"))) {
                echo "Found PHP File Directory {$module_root_file_or_dir}, Converting\n";
                $code_directory_contents = array_diff(scandir($item_path), array('.', '..'));
                foreach ($code_directory_contents as $code_directory_file) {
                    if ($module_root_file_or_dir == "View" && in_array($code_directory_file, $available_clients)) {

                        echo "Found View Client Directory " . $item_path . DIRECTORY_SEPARATOR . $code_directory_file . ", Copying\n";
                        $view_client_directory_contents = array_diff(scandir($item_path . DIRECTORY_SEPARATOR . $code_directory_file), array('.', '..'));
                        foreach ($view_client_directory_contents as $view_client_directory_file) {

                            $new_dir = $client_directory . $module_name . DIRECTORY_SEPARATOR . $module_root_file_or_dir . DIRECTORY_SEPARATOR . $code_directory_file;

                            if (!is_dir($new_dir)) {
                                echo "Creating non existent directory {$new_dir}\n";
                                system('mkdir -p ' . $new_dir);
                            }

                            $temp_original_file = $item_path . DIRECTORY_SEPARATOR . $code_directory_file . DIRECTORY_SEPARATOR . $view_client_directory_file;
                            $new_file = $client_directory . $module_name . DIRECTORY_SEPARATOR . $module_root_file_or_dir . DIRECTORY_SEPARATOR . $code_directory_file . DIRECTORY_SEPARATOR . $view_client_directory_file;
                            echo "Copying File {$temp_original_file} to {$new_file}\n";
                            copy($temp_original_file, $new_file);
                        }
                    } else {
                        $new_dir = $client_directory . $module_name . DIRECTORY_SEPARATOR . $module_root_file_or_dir . DIRECTORY_SEPARATOR;

                        if (!is_dir($new_dir)) {
                            echo "Creating non existent directory {$new_dir}\n";
                            passthru('mkdir -p ' . $new_dir);
                        }
                        $temp_original_file = $item_path . DIRECTORY_SEPARATOR . $code_directory_file;
                        $new_file = $client_directory . $module_name . DIRECTORY_SEPARATOR . $module_root_file_or_dir . DIRECTORY_SEPARATOR . $code_directory_file;
                        if (substr($new_file, -4, 4) === '.php') {
                            echo "Switching .php to .fephp\n";
                            $new_file = str_replace('.php', '.fephp', $new_file);
                        }
                        echo "Copying File {$temp_original_file} to {$new_file}\n";
                        copy($temp_original_file, $new_file);
                    }

                }

            } else {
                $new_file = $client_directory . $module_name . DIRECTORY_SEPARATOR . $module_root_file_or_dir;
            }
        }
    }

}

echo "Copying Raw Core Directory {$core_dir_path} to {$client_root}\n";
system('rm -rf ' . $client_root.'core');
system('cp -r ' . $core_dir_path . ' ' . $client_root );