<?php
namespace Base\Module;

use Exception;

class ModuleServer implements  IModuleServer {

    private $__modules=[];

    public function __construct(array $modules=[]){
        $this->setModule($modules);
    }

    public function modules(){
        return(array_keys($this->__modules));
    }

    public function has($name){
        return(isset($this->__modules[$name]));
    }

    public function execute($name,$action=null,array $params=[]){
        $module=$this->getModule($name);

        if(!$module){
            throw new Exception('TranslAide\\Module\\ModuleServer::execute(): Module "'.$name.'" does not exist');
        }

        return($module->execute($action,$params));
    }

    public function getModule($name){
        return(isset($this->__modules[$name])?$this->__modules[$name]:null);
    }

    public function setModule($name,IModule $module=null){
        if(is_array($name)){
            foreach($name as $n=>$m){
                $this->setModule($n,$m);
            }
        }
        else {
            if($module){
                $this->__modules[$name]=$module;
            }
            else {
                unset($this->__modules[$name]);
            }
        }
    }

}