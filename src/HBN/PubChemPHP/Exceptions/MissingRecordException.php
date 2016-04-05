<?php namespace HBN\PubChemPHP\Exceptions;

use Exception;

class MissingRecordException extends Exception {

    public function __toString()
    {
        return "Missing record.  Please call Api->request()";
    }
}
