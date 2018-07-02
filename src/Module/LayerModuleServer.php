<?php
namespace Base\Module;

use Exception;

class LayerModuleServer implements IModuleServer {

    private $__servers=[];

    public function __construct(array $servers=[]){
        $this->setServer($servers);
    }

    public function modules(){
        $modules=[];

        foreach($this->__servers as $server){
            $modules=array_merge($server->modules(),$modules);
        }

        return($modules);
    }

    public function has($name){
        foreach($this->__servers as $server){
            if($server->has($name)){
                return(true);
            }
        }

        return(false);
    }

    public function execute($name,$action=null,array $params=[]){
        foreach($this->__servers as $server){
            if($server->has($name)){
                return($server->execute($name,$action,$params));
            }
        }

        return(null);
    }

    public function servers(){
        return(array_keys($this->__servers));
    }

    public function getServer($name){
        return(isset($this->__servers[$name])?$this->__servers[$name]:null);
    }

    public function setServer($name,IModuleServer $server=null){
        if(is_array($name)){
            foreach($name as $n=>$s){
                if(!isset($s) or !($s instanceof IModuleServer)){
                    throw new Exception('TranslAide\\Module\\LayerModuleServer::setServer(): "'.$n.'" does not implement IModuleServer');
                }

                $this->setServer($n,$s);
            }

            return;
        }

        if(isset($server)){
            $this->__servers[$name]=$server;
        }
        else {
            unset($this->__servers[$name]);
        }
    }

}