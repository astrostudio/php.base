<?php
namespace Base\Module;

use Exception;

class ModuleFactoryBuilder implements IModuleBuilder {

    private $__factories=[];

    public function __construct(array $factories=[]){
        $this->setFactory($factories);
    }

    public function modules(){
        return(array_keys($this->__factories));
    }

    public function has($name){
        return(isset($this->__factories[$name]));
    }

    public function get($name,array $options=[]){
        $factory=$this->getFactory($name);

        if(!$factory){
            throw new Exception('TranslAide\\Module\\ModuleFactoryBuilder::get(): No factory "'.$name.'"');
        }

        return($factory->get($options));
    }

    public function getFactory($name){
        return(isset($this->__factories[$name])?$this->__factories[$name]:null);
    }

    public function setFactory($name,IModuleFactory $factory=null){
        if(is_array($name)){
            foreach($name as $n=>$f){
                if(!isset($f) or !($f instanceof IModuleFactory)){
                    throw new Exception('TranslAide\\Module\\ModuleFactoryBuilder::setFactory(): "'.$n.'" does not implement IModuleFactory');
                }

                $this->setFactory($n,$f);
            }

            return;
        }

        if(isset($factory)){
            $this->__factories[$name]=$factory;
        }
        else {
            unset($this->__factories[$name]);
        }
    }

}