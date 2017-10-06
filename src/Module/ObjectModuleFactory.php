<?php
namespace Base\Module;

class ObjectModuleFactory implements IModuleFactory {

    private $__factory=null;
    private $__actions=null;

    public function __construct($factory,array $actions=[]){
        $this->__factory=$factory;
        $this->__actions=$actions;
    }

    public function get(array $options=[]){
        $factory=!empty($options['factory'])?$options['factory']:$this->__factory;

        if(!isset($factory)){
            return(null);
        }

        $object=null;

        if(is_callable($factory)){
            $object=call_user_func($factory,$options);
        }

        if(!$object){
            return(null);
        }

        $actions=!empty($options['action'])?$options['action']:$this->__actions;

        return(new ObjectModule($object,$actions));
    }

}