<?php
namespace Base\Relation;

class CallableRelation extends BaseRelation
{
    protected $_callable;

    public function __construct(callable $callable){
        $this->_callable=$callable;
    }

    public function isA($subConcept,$concept):bool
    {
        return(call_user_func($this->_callable,$subConcept,$concept));
    }
}
