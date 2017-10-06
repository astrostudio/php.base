<?php
namespace Base\Module;

class ProxyModuleFactory implements IModuleFactory {

    private $__factory=null;

    public function __construct(IModuleFactory $factory){
        $this->__factory=$factory;
    }

    public function get(array $options=[]){
        if(!$this->__factory){
            return(null);
        }

        return($this->__factory->get($options));
    }
}