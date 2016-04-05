<?php namespace HBN\PubChemPHP;

use GuzzleHttp\Client;
use HBN\PubChemPHP\Config\Config;

class Request {

    /**
     * GuzzleHttp Client
     */
    private static $client;

    private static function getClientInstance()
    {
        if (!self::$client) {
            self::$client = new Client(); 
        }

        return self::$client;
    }

    public static function getCompound($cid)
    {
        return self::get($cid, 'cid', 'compound', null, 'JSON'); 
    }

    public static function getCompoundSynonyms($cid)
    {
        return self::get($cid, 'cid', 'compound', 'synonyms', 'JSON'); 
    }

    public static function get($identifier, $namespace, $domain, $operation, $output)
    {
        $vals = array_filter([$domain, $namespace, $identifier, $operation, $output]);
        $url = Config::get('api_base') . '/' . join('/', $vals);

        $res = self::getClientInstance()->post($url);

        return json_decode($res->getBody());
    }
}
