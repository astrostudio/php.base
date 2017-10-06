<?php
namespace Base\Module;

class CallableModuleBuilder implements IModuleBuilder {

    private $__callable=null;

    public function __construct(callable $callable){
        $this->__callable=$callable;
    }

    public function modules(){
        return(call_user_func($this->__callable,'modules'));
    }

    public function has($name){
        return(call_user_func($this->__callable,'has',$name));
    }

    public function get($name,array $options=[]){
        return(call_user_func($this->__callable,'get',$options));
    }
}