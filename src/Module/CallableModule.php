<?php
namespace Base\Module;

class CallableModule implements IModule {

    private $__callable=null;

    public function __construct(callable $callable){
        $this->__callable=$callable;
    }

    public function execute($action=null,array $params=[]){
        return(call_user_func($this->__callable,$action,$params));
    }
}