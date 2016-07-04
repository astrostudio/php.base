<?php
require_once('IBaseBuilder.php');
require_once('IBaseFactory.php');

class BaseBuilder implements IBaseBuilder {
    
    static private $__builders=array();

    static public function getBuilder($name){;
        if(!isset(self::$__builders[$name])){
            return(null);
        }
        
        return(self::$__builders[$name]);
    }
    
    static public function setBuilder($name,IBaseBuilder $builder){
        if($builder){
            self::$__builders[$name]=$builder;
        }
        else {
            unset(self::$__builders[$name]);
        }
    }
    
    private $__factories=array();
    
    public function __construct($factories=array()){
        $this->__factories=array();

        foreach($factories as $name=>$factory){
            $this->setFactory($name,$factory);
        }
    }
    
    public function get($name,$options=array()){
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
    
    public function setFactory($name,IBaseFactory $factory){
        if($factory){
            $this->__factories[$name]=$factory;
        }
        else {
            unset($this->__factories[$name]);
        }            
    }
}

