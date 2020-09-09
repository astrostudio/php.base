<?php
namespace Base\Relation;

class AlwaysRelation extends BaseRelation
{
    public function isA($subConcept,$concept):bool
    {
        return(true);
    }
}
