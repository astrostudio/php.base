<?php
namespace Base\Relation;

class InRelation extends ProxyRelation
{
    public function isA($subConcept,$concept):bool
    {
        if(!is_array($concept)){
            return(false);
        }

        foreach($concept as $item){
            if(parent::isA($subConcept,$item)){
                return(true);
            }
        }

        return(false);
    }
}
