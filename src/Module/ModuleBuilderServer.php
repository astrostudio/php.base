<?php
namespace Base\Module;

use Exception;

class ModuleBuilderServer implements IModuleServer {

    private $__builder=null;
    private $__key=null;

    public function __construct(IModuleBuilder $builder,$key='options'){
        $this->__builder=$builder;
        $this->__key=$key;
    }

    public function modules(){
        return($this->__builder?$this->__builder->modules():[]);
    }

    public function has($name){
        return($this->__builder?$this->__builder->has($name):false);
    }

    public function execute($name,$action=null,array $params=[]){
        if(!$this->__builder){
            throw new Exception('TranslAide\\Module\\ModuleBuilderServer::execute(): No builder');
        }

        $module=$this->__builder->get($name,!empty($params[$this->__key])?$params[$this->__key]:[]);

        if(!$module){
            throw new Exception('TranslAide\\Module\\ModuleBuilderServer::execute(): No module "'.$name.'"');
        }

        return($module->execute($action,$params));
    }

}