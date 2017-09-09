<?php

define('ISOPHP_CLIENT_SERVER_SIDE', true) ;

require("core/constants.fephp") ;
require("core/app_vars.fephp") ;
require("core/isophp.fephp") ;
require("core/init.fephp") ;
require("core/WindowMessage.fephp") ;
require("core/bootstrap.fephp") ;
require("core/index.fephp") ;

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title></title>
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/loader.css">
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/bootstrap-theme.css">
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/default.css">
        <link rel="stylesheet" type="text/css" href="app/Default/Assets/css/clients/web/client.css">
    </head>

    <body class="drag_body">
        <div id="message_overlay"></div>
        <div id="app-loader" class="app-loader"></div>
        <div id="template" class="app">
            <?php
                echo \Core\View::$server_template ;
            ?>
        </div>
    </body>

    <script type="text/javascript" src="/uniter_bundle/bundle.js"></script>

</html>
