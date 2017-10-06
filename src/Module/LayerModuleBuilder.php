<?php
namespace Base\Module;

use Exception;

class LayerModuleBuilder implements IModuleBuilder {

    private $__builders=null;

    public function __construct(array $builders=[]){
        $this->setBuilder($builders);
    }

    public function modules(){
        $modules=[];

        foreach($this->__builders as $builder){
            $modules=array_merge($builder->modules(),$modules);
        }

        return($modules);
    }

    public function has($name){
        foreach($this->__builders as $builder){
            if($builder->has($name)){
                return(true);
            }
        }

        return(false);
    }

    public function get($name,array $options=[]){
        foreach($this->__builders as $builder){
            if($builder->has($name)){
                return($builder->get($name,$options));
            }
        }

        return(null);
    }

    public function getBuilder($name){
        return(isset($this->__builders[$name])?$this->__builders[$name]:null);
    }

    public function setBuilder($name,IModuleBuilder $builder=null){
        if(is_array($name)){
            foreach($name as $n=>$b){
                if(!isset($b) or !($b instanceof IModuleBuilder)){
                    throw new Exception('TranslAide\\Module\\LayerModuleBuilder::setBuilder(): "'.$n.'" does not implement IModuleBuilder');
                }

                $this->setBuilder($n,$b);
            }

            return;
        }

        if(isset($builder)){
            $this->__builders[$name]=$builder;
        }
        else {
            unset($this->__builders[$name]);
        }
    }

}