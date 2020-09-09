<?php
namespace Base\Relation;

class StarRelation extends ProxyRelation
{
    const STAR='*';

    protected $_star;

    public function __construct(RelationInterface $relation=null,string $star=self::STAR){
        parent::__construct($relation);

        $this->_star=$star;
    }

    public function isA($subConcept,$concept):bool
    {
        if($concept===$this->_star){
            return(true);
        }

        return(parent::isA($subConcept,$concept));
    }
}
