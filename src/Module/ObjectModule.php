<?php
namespace Base\Module;

class ObjectModule implements IModule {

    private $__object=null;
    private $__actions=[];

    public function __construct($object,array $actions=[]){
        $this->__object=$object;
        $this->__actions=$actions;
    }

    public function getObject(){
        return($this->__object);
    }

    public function setObject($object=null){
        $this->__object=$object;
    }

    public function execute($action=null,array $options=[]){
        $a=isset($action)?$action:'default';

        if(empty($this->__actions[$a])){
            throw new \Exception('TranslAide\\Module\\ObjectModule: Action "'.$action.'" does not exist');
        }

        $method=!empty($this->__actions[$a]['method'])?$this->__actions[$a]['method']:$a;

        if(is_callable($method)){
            $result=call_user_func($method,$this->__object,$action,$options);
        }
        else {
            $params=!empty($this->__actions[$a]['params'])?$this->__actions[$a]['params']:[];
            $args=[];

            foreach($params as $param){
                if(is_array($param)){
                    $arg=[];

                    foreach($param as $param1){
                        if(isset($options[$param1])){
                            $arg[$param1]=$options[$param1];
                        }
                    }

                    $args[]=$arg;
                }
                else if($param=='*'){
                    $args[]=$options;
                }
                else {
                    $args[] = isset($options[$param])?$options[$param]:null;
                }
            }

            $result = call_user_func_array([$this->__object, $method], $args);
        }

        return($result);
    }

}