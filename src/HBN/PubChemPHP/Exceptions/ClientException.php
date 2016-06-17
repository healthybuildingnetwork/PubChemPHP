<?php namespace HBN\PubChemPHP\Exceptions;

use Exception;

class ClientException extends Exception {

    public function __toString()
    {
        return "No record found in the PubChem API.";
    }
}
