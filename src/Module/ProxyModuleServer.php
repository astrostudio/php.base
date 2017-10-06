<?php
namespace Base\Module;

use Exception;

class ProxyModuleServer implements IModuleServer {

    private $__server=null;

    public function __construct(IModuleServer $server=null){
        $this->__server=$server;
    }

    public function modules(){
        return($this->__server?$this->__server->modules():[]);
    }

    public function has($name){
        return($this->__server?$this->__server->has($name):false);
    }

    public function execute($name,$action=null,array $params=[]){
        if(!$this->__server){
            throw new Exception('TranslAide\\Module\\ProxyModuleServer::execute(): No server');
        }

        return($this->__server->execute($name,$action,$params));
    }

}