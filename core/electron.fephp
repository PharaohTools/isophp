<?php

Namespace ISOPHP ;

class electron {
    public static $app ;
    public static $BrowserWindow ;
    public static function application_controls($BrowserWindow) {
        // \ISOPHP\js_core::$console->log("app controls") ;
        // \ISOPHP\js_core::$console->log("application controls inititialized") ;
        \ISOPHP\js_core::$window->document->getElementById("btn-min")->addEventListener("click", function () use ($BrowserWindow)  {
            $window = $BrowserWindow->getCurrentWindow();
            $window->minimize();
        });

        \ISOPHP\js_core::$window->document->getElementById("btn-max")->addEventListener("click", function () use ($BrowserWindow)  {
            $window = $BrowserWindow->getCurrentWindow();
            $window->maximize();
        });

        \ISOPHP\js_core::$window->document->getElementById("btn-close")->addEventListener("click", function () use ($BrowserWindow)  {
            $window = $BrowserWindow->getCurrentWindow();
            $window->close();
        });
    }
}