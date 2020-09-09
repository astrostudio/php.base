<?php
namespace Base\Relation;

class ListRelation extends ProxyRelation {

    protected $_list=null;

    public function __construct(RelationInterface $relation,ListRelation $list=null){
        parent::__construct($relation);

        $this->_list=$list;
    }

    public function isA($subConcept,$concept): bool{
        if(parent::isA($subConcept,$concept)){
            return(true);
        }

        if(!$this->_list){
            return(false);
        }

        return($this->_list->isA($subConcept,$concept));
    }

}
