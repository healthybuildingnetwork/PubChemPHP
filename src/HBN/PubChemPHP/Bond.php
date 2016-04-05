<?php namespace HBN\PubchemPHP;

class Bond {

    public $aid1;
    public $aid2;
    public $order;

    private $style;

    public function __construct($aid1, $aid2, $order)
    {
        $this->aid1 = $aid1;
        $this->aid2 = $aid2;
        $this->order = $order;

        // TODO
        //$this->style;
    }

    public function style()
    {
        
    }

}
