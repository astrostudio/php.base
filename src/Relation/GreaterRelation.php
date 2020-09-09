<?php
namespace Base\Relation;

class GreaterRelation extends BaseRelation {

    public function isA($subConcept,$concept): bool{
        if(!is_numeric($subConcept) or !is_numeric($concept)){
            return(false);
        }

        return($subConcept>=$concept);
    }

}
