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
        return self::get($cid, 'cid', 'compound', null, 'JSON', null); 
    }

    public static function getCompoundSynonyms($cid)
    {
        return self::get($cid, 'cid', 'compound', 'synonyms', 'JSON', null); 
    }

    public static function getCompoundFormula($cid)
    {
        return self::get($cid, 'cid', 'compound', 'property', 'JSON', 'MolecularFormula,InChIKey'); 
    }

    public static function getCompoundImage($cid)
    {
        $record_type = '2d';
        $image_size = 'small';
        return self::getUrl($cid, 'cid', 'compound', null, 'PNG', null, compact('record_type', 'image_size'));
    }

    public static function getCompoundCids($cid)
    {
        $cids_type = 'component';
        return self::get($cid, 'cid', 'compound', 'cids', 'JSON', null, compact('cids_type')) ;
    }

    private static function getUrl($identifier, $namespace, $domain, $operation, $output, $search_type, $params = [])
    {
        $vals = array_filter([$domain, $namespace, $identifier, $operation, $search_type, $output]);
        $url = Config::get('api_base') . '/' . join('/', $vals);

        if (sizeof($params) > 0) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    public static function get($identifier, $namespace, $domain, $operation, $output, $params = [])
    {
        $url = self::getUrl($identifier, $namespace, $domain, $operation, $output, $params);

        $res = self::getClientInstance()->post($url);

        return json_decode($res->getBody());
    }
}

