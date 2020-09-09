<?php
namespace Base\Relation;

class EachRelation extends BaseRelation {

    public function isA($subConcept,$concept): bool{
        if($concept instanceof Each){
            return(true);
        }

        return(false);
    }

}
