<?php
namespace Base\Relation;

class EqualRelation extends BaseRelation {

    public function isA($subConcept,$concept): bool{
        return($subConcept==$concept);
    }

}
