<?php
namespace Base\Module;

use Exception;

class ModuleServerModule implements IModule {

    private $__server=null;
    private $__options=null;

    public function __construct(IModuleServer $server,array $options=[]){
        $this->__server=$server;
        $this->__options=array_merge([
            'name'=>'_name',
            'default'=>null,
            'modules'=>null,
            'has'=>null
        ],$options);
    }

    public function execute($action=null,array $params=[]){
        if(!$this->__server){
            throw new Exception('TranslAide\\Module\\ModuleServerModule::execute(): No server');
        }

        if(!empty($this->__options['modules']) and ($action==$this->__options['modules'])){
            return($this->__server->modules());
        }

        if(!empty($params[$this->__options['name']])){
            $name=$params[$this->__options['name']];
        }
        else if(!empty($this->__options['default'])){
            $name=$this->__options['default'];
        }

        if(empty($name)){
            throw new Exception('TranslAide\\Module\\ModuleServerModule::execute(): No module name');
        }

        if(!empty($this->__options['has']) and ($action==$this->__options['has'])){
            return($this->__server->has($params[$this->__options['name']]));
        }

        return($this->__server->execute($name,$action,$params));
    }
}