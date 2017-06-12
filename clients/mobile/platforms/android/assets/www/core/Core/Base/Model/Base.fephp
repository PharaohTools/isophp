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


}
