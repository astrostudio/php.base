<?php
namespace Base\Module;

class ParamModule extends ProxyModule {

    private $__params=null;

    public function __construct(IModule $module,array $params=[]){
        parent::__construct($module);

        $this->__params=$params;
    }

    public function execute($action=null,array $params=[]){
        $a=isset($action)?$action:'-';

        if(!empty($this->__params[$a])){
            $params=array_merge_recursive($this->__params[$a],$params);
        }
        else if(!empty($this->__params['*'])){
            $params=array_merge_recursive($this->__params['*'],$params);
        }

        if(!empty($this->__params['+'])){
            $params=array_merge_recursive($this->__params['+'],$params);
        }

        return(parent::execute($action,$params));
    }

}