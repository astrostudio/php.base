<?php
namespace Base\Relation;

class ProxyRelation extends BaseRelation
{
    protected $_relation;

    public function __construct(RelationInterface $relation=null){
        $this->_relation=$relation;
    }

    public function isA($subConcept,$concept):bool
    {
        return($this->_relation?$this->_relation->isA($subConcept,$concept):false);
    }
}
