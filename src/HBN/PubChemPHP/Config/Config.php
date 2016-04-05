<?php namespace HBN\PubChemPHP\Config;

class Config {

    protected $config;

    protected static $instance;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../../config.php';
    }

    public static function get($key)
    {
        $instance = self::getInstance();
        return $instance->config[$key]; 
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Config;
        } 

        return self::$instance;
    }
}
