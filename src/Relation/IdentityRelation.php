<?php
namespace Base\Relation;

class IdentityRelation extends BaseRelation {

    public function isA($subConcept,$concept): bool{
        return($subConcept===$concept);
    }

}
