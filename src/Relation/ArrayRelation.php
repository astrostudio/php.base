<?php
namespace Base\Relation;

class ArrayRelation extends ProxyRelation
{
    protected $_relations=[];

    public function __construct(array $relations=[],RelationInterface $relation=null){
        parent::__construct($relation);

        $this->setRelation($relations);
    }

    public function isA($subConcept,$concept):bool
    {
        if(!is_array($subConcept) or !is_array($concept)){
            return(false);
        }

        $keys=array_keys($concept);

        foreach($keys as $key){
            if(!array_key_exists($key,$subConcept)){
                return(false);
            }

            if(isset($this->_relations[$key])){
                if(!$this->_relations[$key]->isA($subConcept[$key],$concept[$key])){
                    return(false);
                }
            }
            else {
                if(!parent::isA($subConcept[$key],$concept[$key])){
                    return(false);
                }
            }
        }

        return(true);
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
