<?php

Namespace Core ;

class WindowMessage {

    public static function showMessage($msg_data, $msg_type) {
        $jQuery = \ISOPHP\js_core::$jQuery ;
        $message_overlay = $jQuery('#message_overlay') ;
        $msg_hash = self::makeid() ;
        $message_overlay->append(self::getMessageHTML($msg_data, $msg_type, $msg_hash)) ;
//        // \ISOPHP\js_core::$console->log('come on then') ;
        $window = \ISOPHP\js_core::$window ;
        $window->setTimeout(function() use ($msg_hash) {
            self::hideMessage($msg_hash) ;
        }, 3000) ;
    }

    public static function hideMessage($msg_hash) {
        $jQuery = \ISOPHP\js_core::$jQuery ;
        $message_overlay = $jQuery('#msg_'.$msg_hash) ;
        $message_overlay->remove() ;
        return true ;
    }

    public static function getMessageHTML($msg_data, $msg_type, $msg_hash) {
        if ($msg_type === "good") {
            $msg_class = ' btn-success' ; }
        else {
            $msg_class = ' btn-danger' ; }
        $h = '' ;
        $h = $h . '  <div id="msg_'.$msg_hash.'" class="fullRow">' ;
        $h = $h . '    <span class="message_text '.$msg_class.'">' ;
        $h = $h . $msg_data ;
        $h = $h . '    </span>' ;
        $h = $h . '  </div>' ;
        return $h ;
    }


    public static function randomNum() {
//        $to_floor = \ISOPHP\js_core::$window->Math->random() * $hi;
        $r = \ISOPHP\js_core::$window->Math->random() ;
        $to_floor = $r * 62;
        return \ISOPHP\js_core::$window->Math->floor($to_floor);
    }

    public static function randomChar(){
        $char_ray = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0') ;
        $rand = self::randomNum() ;
        return $char_ray[$rand];
    }

    public static function makeid(){
        $length = 16 ;
        $str = "";
        for($i = 0; $i < $length; $i=$i+1) {
            $str = $str . self::randomChar();
        }
        return $str;
    }

    public static function areYouSure($message, $yesfunction = null) {
        $overlay_html = self::getOverlayHTML('confirm', $message) ;
        $jQuery = \ISOPHP\js_core::$jQuery ;
        $jQuery('.overlay_fephp')->remove() ;
        $jQuery('body')->append($overlay_html) ;
        $jQuery('#overlay_confirm')->show() ;
        $jQuery('#close_page_overlay')->on('click', function() use ($jQuery) {
            self::closeOverlay() ;
        } );
        $jQuery('#overlay_no_button')->on('click', function() use ($jQuery) {
            self::closeOverlay() ;
        } );
        $jQuery('#overlay_yes_button')->on('click', function() use ($jQuery, $yesfunction) {
            if ($yesfunction !== null) {
                $yesfunction() ;
            }
            self::closeOverlay() ;
        } );
    }

    public static function showOverlay($message, $data=null) {
        $overlay_html = self::getOverlayHTML('ok', $message, $data) ;
        $jQuery = \ISOPHP\js_core::$jQuery ;
        $jQuery('.overlay_fephp')->remove() ;
        $jQuery('body')->append($overlay_html) ;
        $jQuery('#overlay_ok')->show() ;
        $jQuery('#close_page_overlay')->on('click', function() use ($jQuery) {
            self::closeOverlay() ;
        } );
        $jQuery('#overlay_ok_button')->on('click', function() use ($jQuery) {
            self::closeOverlay() ;
        } );
    }

    public static function closeOverlay() {
        $jQuery = \ISOPHP\js_core::$jQuery ;
        $jQuery('#overlay_ok')->fadeOut('fast') ;
        $jQuery('.overlay_fephp')->fadeOut('fast') ;
    }

    public static function getOverlayHTML($overlay_type, $title, $data=null) {
        $htmlvar  = '<div id="overlay_'.$overlay_type.'" class="overlay_fephp"> ';
        $htmlvar = $htmlvar . '    <div class="overlay_inner"> ';
        $htmlvar = $htmlvar . '        <div id="close_button_div"> ';
        $htmlvar = $htmlvar . '            <span id="close_page_overlay"> ';
        $htmlvar = $htmlvar . '                <img src="Assets/Modules/DefaultSkin/image/close_button.png" /> ';
        $htmlvar = $htmlvar . '            </span> ';
        $htmlvar = $htmlvar . '        </div> ';
        $htmlvar = $htmlvar . '        <div class="overlay_content"> ';
        $htmlvar = $htmlvar . '            <h3 class="progressTitle">' . $title . '</h3> ';
        if ($data !== null) {
            $htmlvar = $htmlvar . '            <div class="fullWidth"> ';
            $htmlvar = $htmlvar . '                <div id="overlay_data">'.$data.'</div>';
            $htmlvar = $htmlvar . '            </div> ';
        }
        $htmlvar = $htmlvar . '            <div class="fullWidth"> ';
        if ($overlay_type === 'confirm') {
            $htmlvar = $htmlvar . '                <span id="overlay_yes_button" class="btn btn-success hvr-float-shadow">Yes</span> ';
            $htmlvar = $htmlvar . '                <span id="overlay_no_button" class="btn btn-warning hvr-float-shadow">No</span> ';
        } else if ($overlay_type === 'ok') {
            $htmlvar = $htmlvar . '                <span id="overlay_ok_button" class="btn btn-warning hvr-float-shadow">OK</span> ';
        }
        $htmlvar = $htmlvar . '            </div> ';
        $htmlvar = $htmlvar . '        </div> ';
        $htmlvar = $htmlvar . '    </div> ';
        $htmlvar = $htmlvar . '</div> ';
        return $htmlvar ;
    }


}
