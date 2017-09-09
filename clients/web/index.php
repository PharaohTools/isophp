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
        <link rel="stylesheet" href="app/ISOPHPExample/Assets/css/animate.css">
        <link rel="stylesheet" href="app/ISOPHPExample/Assets/css/icomoon.css">
        <link rel="stylesheet" href="app/ISOPHPExample/Assets/css/bootstrap.css">
        <link rel="stylesheet" href="app/ISOPHPExample/Assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="app/ISOPHPExample/Assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="app/ISOPHPExample/Assets/css/style.css">
        <script src="app/ISOPHPExample/Assets/js/modernizr-2.6.2.min.js"></script>
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
