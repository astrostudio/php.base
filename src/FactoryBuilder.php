<?php
namespace Base;

class FactoryBuilder implements IBuilder {
    
    private $__factories=[];
    
    public function __construct(array $factories=[]){
        $this->setFactory($factories);
    }
    
    public function get($name,array $options=[]){
        $factory=$this->getFactory($name);
        
        if(!$factory){
            return(null);
        }
        
        return($factory->get($options));
    }
    
    public function getFactory($name){
        if(!isset($this->__factories[$name])){
            return(null);
        }
        
        return($this->__factories[$name]);
    }
    
    public function setFactory($name,IFactory $factory=null){
        if(is_array($name)){
            foreach($name as $n=>$f){
                $this->setFactory($n,$f);
            }

            return;
        }

        if($factory){
            $this->__factories[$name]=$factory;
        }
        else {
            unset($this->__factories[$name]);
        }            
    }
}

