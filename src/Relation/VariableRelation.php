<?php
namespace Base\Relation;

class VariableRelation extends ProxyRelation
{
    protected $_variables = [];

    public function __construct(RelationInterface $relation = null)
    {
        parent::__construct($relation);
    }

    public function isA($subConcept, $concept): bool
    {
        if($this->isVariable($subConcept)){
            if($this->isVariable($concept)){
               if($concept===$subConcept){
                   if($this->has($concept)){
                       return(parent::isA($this->get($concept),$this->_variables[$concept]));
                   }

                   return(true);
               }

               if($this->has($subConcept)){
                   if($this->has($concept)){
                       return(parent::isA($this->get($subConcept),$this->get($concept)));
                   }

                   if(!parent::isA($this->get($subConcept),$this->get($subConcept))) {
                       return (false);
                   }

                   $this->set($concept,$this->get($subConcept));

                   return(true);
               }

               if($this->has($concept)){
                   if(!parent::isA($this->get($subConcept),$this->get($concept))) {
                       return (false);
                   }

                   $this->set($subConcept,$this->get($concept));

                   return(true);
               }

               return(false);
            }

            if($this->has($subConcept)){
                return(parent::isA($this->get($subConcept),$concept));
            }

            if(!parent::isA($concept,$concept)){
                return(false);
            }

            $this->set($subConcept,$concept);

            return(true);
        }

        if($this->isVariable($concept)){
            if($this->has($concept)){
                return(parent::isA($subConcept,$this->get($concept)));
            }

            if(!parent::isA($subConcept,$subConcept)){
                return(false);
            }

            $this->set($concept,$subConcept);

            return(true);
        }

        return (parent::isA($subConcept, $concept));
    }

    public function isVariable($concept): bool
    {
        return (is_string($concept) && mb_substr($concept, 0, 1) == '@');
    }

    public function has(string $name):bool
    {
        return(array_key_exists($name,$this->_variables));
    }

    public function get(string $name){
        return($this->variables[$name]??null);
    }

    public function set(string $name,$concept){
        $this->_variables[$name]=$concept;
    }

}
