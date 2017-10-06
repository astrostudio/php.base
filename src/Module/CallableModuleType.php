<?php
namespace Base\Module;

class CallableModuleType implements IModuleType {

    private $__callable=null;

    public function __construct(callable $callable){
        $this->__callable=$callable;
    }

    public function check($value){
        return(call_user_func($this->__callable,$value));
    }
}