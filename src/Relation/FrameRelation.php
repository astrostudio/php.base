<?php
namespace Base\Relation;

class FrameRelation extends ArrayRelation
{
    protected $_combination;

    public function __construct(array $relations=[],RelationInterface $combination=null,RelationInterface $relation=null){
        parent::__construct($relations,$relation);

        $this->_combination=new CombinationRelation($combination);
        $this->setRelation($relations);
    }

    public function isA($subConcept,$concept):bool
    {
        if(!is_array($subConcept) or !is_array($concept)){
            return(false);
        }

        $subMap=[];
        $subSet=[];

        foreach($subConcept as $subKey=>$subItem){
            if(is_int($subKey)){
                $subSet[]=$subItem;
            }
            else {
                $subMap[$subKey]=$subItem;
            }
        }

        $map=[];
        $set=[];

        foreach($concept as $key=>$item){
            if(is_int($key)){
                $set[]=$item;
            }
            else {
                $map[$key]=$item;
            }
        }

        return(parent::isA($subMap,$map) && (!isset($this->_combination) or $this->_combination->isA($subSet,$set)));
    }
}
