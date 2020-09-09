<?php
namespace Base\Relation;

class LayerRelation extends BaseRelation
{
    protected $_relations=[];

    public function __construct(array $relations=[]){
        $this->setRelation($relations);
    }

    public function isA($subConcept,$concept):bool
    {
        foreach($this->_relations as $relation){
            if($relation->isA($subConcept,$concept)){
                return(true);
            }
        }

        return(false);
    }

    public function setRelation($key,RelationInterface $relation=null){
        if(is_array($key)){
            foreach($key as $k=>$r){
                $this->setRelation($k,$r);
            }

            return;
        }

        unset($this->_relations[$key]);

        if($relation){
            $this->_relations[$key]=$relation;
        }
    }
}
