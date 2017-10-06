<?php
namespace Base\Module;

use Exception;

class MethodModule implements IModule {

    private $__actions=[];

    public function __construct(array $actions=[]){
        $this->__actions=$actions;
    }

    public function execute($action=null,array $options=[]){
        $a=!empty($action)?$action:'default';

        if(!isset($this->__actions[$a])){
            throw new Exception('TranslAide\\Module\\MethodModule: Action "'.$a.'" does not exist');
        }

        $args=null;

        if(isset($this->__actions[$a]['params'])) {
            $args = [];

            foreach ($this->__actions[$a]['params'] as $name=>$value) {
                if(is_int($name)) {
                    $args[] = isset($options[$value])?$options[$value]:null;
                }
                else {
                    $args[]=isset($optons[$name])?$options[$name]:$value;
                }
            }
        }

        if(isset($this->__actions[$a]['method'])) {
            $method = $this->__actions[$a]['method'];
        }
        else {
            $method=$action;
        }

        if(is_callable($method)){
            if(isset($args)){
                return(call_user_func_array($method,$args));
            }

            return(call_user_func($method,$options));
        }

        if(isset($args)){
            return(call_user_func_array([$this,$method],$args));
        }

        return(call_user_func([$this,$method],$options));
    }

}