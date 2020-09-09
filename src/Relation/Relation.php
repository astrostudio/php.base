<?php
namespace Base\Relation;

class Relation
{
    static public function generalize(RelationInterface $relation,$subConcept,$concept,bool $each=false){
        if($relation->isA($subConcept,$concept)){
            return($concept);
        }

        if($relation->isA($concept,$subConcept)){
            return($subConcept);
        }

        return($each?new Each():null);
    }

    static public function isEqual(RelationInterface $relation,$subConcept,$concept):bool
    {
        return($relation->isA($subConcept,$concept) and $relation->isA($concept,$subConcept));
    }

    static public function shrinkList(RelationInterface $relation,array $concepts=[]):array
    {
        $subConcepts=[];

        foreach($concepts as $concept){
            foreach($subConcepts as $key=>$subConcept){
                if($relation->isA($concept,$subConcept)){
                    $subConcepts[$key]=$concept;
                }
            }
        }

        return($subConcepts);
    }

}
