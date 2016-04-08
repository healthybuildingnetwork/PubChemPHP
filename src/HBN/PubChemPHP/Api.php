<?php namespace HBN\PubChemPHP;

use HBN\PubChemPHP\Config\Config;
use HBN\PubChemPHP\Exceptions\MissingResponseException;
use HBN\PubChemPHP\Exceptions\MissingApiRecordIdentifierException;

class Api {
    
    /**
     * API base url
     */
    protected $api_base;

    /**
     * Shared GuzzleHttp Client
     */
    protected $client;

    /**
     * Cached response json available to child entities
     */
    protected $json;

    protected $record;

    public function __construct()
    {
    }

    public static function compound()
    {
        return new Compound(); 
    }
    
    /**
     * Resolve the record from json response.  
     *
     * Requires an $apiRecordIdentifier to be declared on the child entity class
     *
     */
    protected function getRecord()
    {
        if (empty($this->apiRecordIdentifier)) {
            throw new MissingApiRecordIdentifierException();
        } 

        if (empty($this->json)) {
            throw new MissingResponseException();
        }

        return $this->json->{$this->apiRecordIdentifier}[0];
    }

}
