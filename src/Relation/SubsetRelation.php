<?php
namespace Base\Relation;

class SubsetRelation extends ProxyRelation
{
    public function isA($subConcept,$concept):bool
    {
        if(!is_array($subConcept)){
            return(false);
        }

        if(!is_array($concept)){
            return(false);
        }

        foreach($concept as $item){
            $found=false;

            foreach($subConcept as $subItem){
                if(parent::isA($subItem,$item)){
                    $found=true;

                    break;
                }
            }

            if(!$found){
                return(false);
            }
        }

        return(true);
    }
}
