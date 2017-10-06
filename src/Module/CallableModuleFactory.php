<?php
namespace Base\Module;

class CallableModuleFactory implements IModuleFactory {

    private $__callable=null;

    public function __construct(callable $callable){
        $this->__callable=$callable;
    }

    public function get(array $options=[]){
        return(call_user_func($this->__callable,$options));
    }
}