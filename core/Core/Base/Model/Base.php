<?php

Namespace Model;

class Base {

    public $params ;

    protected function stripNewLines($inputLine) {
        $inputLine = str_replace("\n", "", $inputLine);
        $inputLine = str_replace("\r", "", $inputLine);
        return $inputLine;
    }

    public function ensureTrailingSlash($str) {
        if (substr($str, -1, 1) != DIRECTORY_SEPARATOR) {
            $str = $str . DIRECTORY_SEPARATOR ;
        }
        return $str ;
    }

    public function performRequest($request_vars, $afterwards) {

        $jQuery = \ISOPHP\js_core::$jQuery ;
        $new_data_string = '' ;

        foreach ($request_vars as $one_var_key => $one_var_val) {
            $new_data_string = $new_data_string.$one_var_key."=".$one_var_val.'&' ;
        }
        $length = \ISOPHP\core::$php->strlen($new_data_string) ;
        $new_data_string = \ISOPHP\core::$php->substr($new_data_string, 0, $length-1) ;
        $new_data_string = \ISOPHP\js_core::$window->encodeURI($new_data_string) ;

        \ISOPHP\js_core::$console->log('perform request with: ', $new_data_string, 'post to:', \Model\Configuration::$SERVER_URL) ;
        $data = array(
            'type' => 'POST',
            'url' => \Model\Configuration::$SERVER_URL,
            'dataType'=> "json",
            'data' => $new_data_string
        ) ;

        $ajax_object = $jQuery->ajax($data);
        $status = $ajax_object->done(
            function ($data) use ($jQuery, $afterwards) {
//                // \ISOPHP\js_core::$console->log('returned request with 1: ', $data) ;
                $this->returned_data = $data ;
//                // \ISOPHP\js_core::$console->log('showing what afterwards is', $afterwards) ;
                if ($afterwards !== null) {
                    $afterwards($data) ;
                }
//                // \ISOPHP\js_core::$console->log('afterwards done') ;
            }
        );

        return $status ;
    }

}
