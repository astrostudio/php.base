<?php
namespace Base\Module;

class ActionModule extends ProxyModule {

    private $__actions=[];

    public function __construct(IModule $module=null,array $actions=[]){
        parent::__construct($module);

        $this->__actions=$actions;
    }

    public function execute($action=null,array $params=[]){
        if(!empty($action)){
            if(isset($this->__actions[$action])){
                if(is_callable($this->__actions[$action])){
                    return(call_user_func($this->__actions[$action],$this,$params));
                }

                return($this->__actions[$action]);
            }
        }

        return(parent::execute($action,$params));
    }

}