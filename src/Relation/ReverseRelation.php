<?php
namespace Base\Relation;

class ReverseRelation extends ProxyRelation {

    public function isA($subConcept,$concept): bool{
        return(!parent::isA($subConcept,$concept));
    }

}
