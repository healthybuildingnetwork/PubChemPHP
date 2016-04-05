<?php namespace HBN\PubChemPHP\Config;

class Constants {

    protected $constants;

    protected static $instance;

    public function __construct()
    {
        $this->constants = require __DIR__ . '/../../../const.php';
    }

    public static function get($key)
    {
        $instance = self::getInstance();
        return $instance->constants[$key]; 
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Constants;
        } 

        return self::$instance;
    }

}

