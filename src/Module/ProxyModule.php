<?php
namespace Base\Module;

use Exception;

class ProxyModule implements IModule {

    private $__module=null;

    public function __construct(IModule $module=null){
        $this->__module=$module;
    }

    public function execute($action=null,array $params=[]){
        if(!$this->__module){
            throw new Exception('TranslAide\\Module\\ProxyModule::execute(): No module');
        }

        return($this->__module->execute($action,$params));
    }

}