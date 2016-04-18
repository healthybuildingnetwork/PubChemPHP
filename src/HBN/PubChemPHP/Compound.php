<?php namespace HBN\PubChemPHP;

use HBN\PubChemPHP\Exceptions\MissingRecordException;

class Compound extends Api {

    protected $apiRecordIdentifier = 'PC_Compounds';

    protected $atoms;
    protected $bonds;

    public function from_cid($cid) {

        $this->json = Request::getCompound($cid);
        $this->record = $this->getRecord();

        $this->setup_atoms();
        $this->setup_bonds();

        return $this;
    }

    private function setup_atoms()
    {
        $this->atoms = []; 

        $aids = $this->record->atoms->aid;
        $elements = $this->record->atoms->element;

        foreach (array_map(null, $aids, $elements) as $set) { 
            $this->atoms[]= new Atom($set[0], $set[1]);
        }
    }

    private function setup_bonds()
    {
        $this->bonds = []; 

        $aid1s = $this->record->bonds->aid1;
        $aid2s = $this->record->bonds->aid2;
        $orders = $this->record->bonds->order;

        foreach (array_map(null, $aid1s, $aid2s, $orders) as $set) {
            $this->bonds[] = new Bond($set[0], $set[1], $set[2]);
        }

        // todo - styles
    }

    public function cid()
    {
        if (!$this->record) throw new MissingRecordException();

        return $this->record->id->id->cid;
    }

    public function atoms()
    {
        if (!$this->record) throw new MissingRecordException();

        return $this->atoms;
    }

    public function elements()
    {
        if (!$this->record) throw new MissingRecordException();

        $elements = []; 

        foreach ($this->atoms as $atom) {
            $elements[]= $atom->element();
        }

        return $elements;
    }

    public function bonds()
    {
        if (!$this->record) throw new MissingRecordException();
         
        return $this->bonds;
    }

    public function smiles()
    {
        if (!$this->record) throw new MissingRecordException();

        return $this->getProp('SMILES', [ 'name' => 'Canonical' ]);
    }

    public function synonyms()
    {
        if (!$this->record) throw new MissingRecordException();

        $results = Request::getCompoundSynonyms($this->cid());

        return $results->InformationList->Information[0]->Synonym;
    }

    public function image()
    {
        $result = Request::getCompoundImage($this->cid()); 

        return $result;
    }

    public function chemical_formula()
    {
        $result = Request::getCompoundFormula($this->cid()); 

        return $result->PropertyTable->Properties[0]->MolecularFormula;
    }
    
    private function getProp($label, $filter = [])
    {
        foreach ($this->record->props as $prop) {
            if ($prop->urn->label == $label) {
                foreach ($filter as $key => $value) {
                    if ($prop->urn->{$key} != $value) {
                        break;
                    }
                }

                if (isset($prop->value->fval)) { return $prop->value->fval; }
                if (isset($prop->value->sval)) { return $prop->value->sval; }
            }
        } 
    }
}
