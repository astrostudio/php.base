<?php
namespace Base\Module;

use Exception;

class PrefixModuleServer extends ProxyModuleServer {

    private $__prefix='';

    public function __construct(IModuleServer $server=null,$prefix=''){
        parent::__construct($server);

        $this->__prefix=$prefix;
    }

    public function modules(){
        $mm=parent::modules();
        $modules=[];

        foreach($mm as $m){
            $modules[]=$this->__prefix.$m;
        }

        return($modules);
    }

    public function has($name){
        if(mb_substr($name,0,mb_strlen($this->__prefix))!=$this->__prefix){
            return(false);
        }

        return(parent::has(mb_substr($name,mb_strlen($this->__prefix))));
    }

    public function execute($name,$action=null,array $params=[]){
        if(mb_substr($name,0,mb_strlen($this->__prefix))!=$this->__prefix){
            throw new Exception('Base\\Module\\PrefixModuleServer: Module "'.$name.'" does not exists');
        }

        return(parent::execute(mb_substr($name,mb_strlen($this->__prefix)),$action,$params));
    }

}