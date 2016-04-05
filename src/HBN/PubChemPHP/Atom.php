<?php namespace HBN\PubChemPHP;

use HBN\PubChemPHP\Config\Constants;

class Atom {

    public $aid;
    public $atomic_number;
    private $element;

    public function __construct($aid, $atomic_number)
    {
        $this->aid = $aid;
        $this->atomic_number = $atomic_number;

        $this->element = Constants::get('elements')[$atomic_number];
    }

    public function element()
    {
        return $this->element; 
    }

}
