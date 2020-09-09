<?php
namespace Base\Relation;

abstract class BaseRelation implements RelationInterface
{
    public function generalize($subConcept,$concept,bool $each=false){
        return(Relation::generalize($this,$subConcept,$concept,$each));
    }

    public function isEqual($subConcept,$concept):bool
    {
        return(Relation::isEqual($this,$subConcept,$concept));
    }

    public function shrinkList(array $concepts=[]):array
    {
        $subConcepts=[];

        foreach($concepts as $concept){
            foreach($subConcepts as $key=>$subConcept){
                if($this->isA($concept,$subConcept)){
                    $subConcepts[$key]=$concept;
                }
            }
        }

        return($subConcepts);
    }
}
