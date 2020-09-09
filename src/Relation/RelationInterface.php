<?php
namespace Base\Relation;

interface RelationInterface
{
    function isA($subConcept,$concept):bool;
}
