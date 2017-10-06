<?php
namespace Base\Module;

use Exception;

class ModuleFactoryModule implements IModule {

    private $__factory=null;
    private $__key=null;

    public function __construct(IModuleFactory $factory,$key='options'){
        $this->__factory=$factory;
        $this->__key=$key;
    }

    public function execute($action=null,array $params=[]){
        if(!$this->__factory){
            throw new Exception('TranslAide\\Module\\ModuleFactoryModule::execute(): No factory');
        }

        $module=$this->__factory->get(isset($options[$this->__key])?$options[$this->__key]:[]);

        if(!$module){
            throw new Exception('TranslAide\\Module\\ModuleFactoryModule::execute(): No module');
        }

        return($module->execute($action,$params));
    }
}