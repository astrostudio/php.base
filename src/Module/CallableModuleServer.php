<?php
namespace Base\Module;

class CallableModuleServer implements IModuleServer {

    private $__callable=null;

    public function __construct(callable $callable){
        $this->__callable=$callable;
    }

    public function modules(){
        return(call_user_func($this->__callable,'modules'));
    }

    public function has($name){
        return(call_user_func($this->__callable,'has'));
    }

    public function execute($name,$action=null,array $params=[]){
        return(call_user_func($this->__callable,'execute',$name,$action,$params));
    }
}