<?php namespace HBN\PubChemPHP\Exceptions;

use Exception;

class MissingResponseException extends Exception {

    public function __toString()
    {
        return "Missing response.  Please call Api->request()";
    }
}
