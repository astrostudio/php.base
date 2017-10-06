<?php
namespace Base\Module;

class ActionModuleFactory extends ProxyModuleFactory {

    private $__actions=[];

    public function __construct(IModuleFactory $factory=null,array $actions=[]){
        parent::__construct($factory);

        $this->__actions=$actions;
    }

    public function get(array $options=[]){
        if(isset($options['actions']) and is_array($options['actions'])) {
            $actions = array_merge($this->__actions, $options['actions']);
        }
        else {
            $actions=$this->__actions;
        }

        return(new ActionModule(parent::get($options),$actions));
    }

}