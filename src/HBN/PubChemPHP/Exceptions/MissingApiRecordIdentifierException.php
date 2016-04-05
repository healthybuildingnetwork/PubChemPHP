<?php namespace HBN\PubChemPHP\Exceptions;

use Exception;

class MissingApiRecordIdentifierException extends Exception {

    public function __toString()
    {
        return "Missing Api Record Identifier.  Please define \$apiRecordIdentifier on API entity";
    }
}
