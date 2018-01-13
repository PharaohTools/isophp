<?php

namespace Model ;

class Configuration {

    public static $config ;

    public static function variable($var) {
        require (REQUIRE_PREFIX.'/core/default.fephp') ;
        $config = \Model\Configuration::$config ;
        $config['ISOPHP_API_SERVER_URL'] = 'http://server.devcloud.'.$config['domain'] ;
        if (isset($config[$var])) {
            return $config[$var];
        }
        return null ;
    }

}

