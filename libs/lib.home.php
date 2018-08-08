<?php
/**
 * Created by PhpStorm.
 * User: carna
 * Date: 23/07/2018
 * Time: 17:26
 */

class home extends baseclass {

    private static $instance;

    public function __construct() {

        // chiama il costruttore del genitore
        parent::__construct();

    }


    public static function getHomeInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

}