<?php
namespace Base\Relation;

class SetRelation extends BaseRelation {

    public function isA($subConcept,$concept): bool{
        if(!is_array($subConcept)){
            return(false);
        }

        if(!is_array($concept)){
            return(false);
        }

        foreach($subConcept as $item){
            if(!in_array($item,$concept)){
                return(false);
            }
        }

        return(true);
    }

}
