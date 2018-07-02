<?php
namespace Base\Module;

class ProxyModuleBuilder implements IModuleBuilder {

    private $__builder=null;

    public function __construct(IModuleBuilder $builder=null){
        $this->__builder=$builder;
    }

    public function modules(){
        return($this->__builder?$this->__builder->modules():[]);
    }

    public function has($name){
        return($this->__builder?$this->__builder->has($name):false);
    }

    public function get($name,array $options=[]){
        return($this->__builder?$this->__builder->get($name,$options):null);
    }

}