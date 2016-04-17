<?php
namespace Base;

use \Exception;

class Base {

    static public function push(&$array,$item){
        if(!empty($item)){
            array_push($array,$item);
        }
    }

	static public function extend(array $data) {
		$args=func_get_args();
		$return=current($args);

		while (($arg = next($args)) !== false) {
			foreach ((array)$arg as $key => $val) {
                if(is_int($key)){
                    $return[]=$val;
                } else if(!empty($return[$key]) && is_array($return[$key]) && is_array($val)) {
					$return[$key]=self::extend($return[$key],$val);
				} else {
					$return[$key]=$val;
				}
			}
		}
        
		return($return);
	}
    
    static public function def(){
        $args=func_get_args();
        
        foreach($args as $arg){
            if(!empty($arg)){
                return($arg);
            }
        }
        
        return(null);
    }
    
    static public function get($data=null,$path=null,$value=null){
        if(!is_array($data)){
            if(empty($path)){
                return($data);
            }
            
            return($value);
        }
        
        if(is_string($path)){
            $path=explode('.',$path);
        }
        
        if(!is_array($path)){
            return($value);
        }
        
        foreach($path as $item){
            if(is_array($data) and isset($data[$item])){
                $data=$data[$item];
            }
            else {
                return($value);
            }
            
        }
        
        return($data);
    }
    
    static public function set(&$data,$path=null,$value=null){
        if(!is_array($data)){
            if(empty($path)){
                if(!isset($value)){
                    unset($data);
                }
                else {                
                    $data=$value;
                }
                
                return($value);
            }
            
            return(false);
        }
        
        if(is_string($path)){
            $path=explode('.',$path);
        }
        
        if(!is_array($path)){
            return(false);
        }
        
        $var=null;
        
        foreach($path as $item){
            if(is_array($data) and isset($data[$item])){
                $var=&$data[$item];
            }
            else {
                return(false);
            }
            
        }
        
        if(!isset($value)){
            unset($var);
        }
        else {                
            $var=$value;
        }

        return($value);        
    }

    static public function evaluate($var,$params=[],$default=null){
        if(!isset($var)){
            return($default);
        }

        if(is_callable($var)){
            return(call_user_func_array($var,$params));
        }

        return($var);
    }

    static public function sequence($items=[],$options=[]){
        foreach($items as $name=>&$item){
            $process=self::evaluate(self::get($options,'before'),[$name,$item],true);
            $break=false;
            $result=null;

            if($process){
                $process=self::evaluate(self::get($item,'before'),[$name,$item],true);

                if($process){
                    try{
                        $result=self::evaluate(self::get($item,'action'),self::get($item,'params',[]));
                        $item['result']=$result;
                        $break=self::get($item,'break');
                        $break=isset($break) and (self::evaluate(self::get($item,'break'),[$name,$item,$result])===$break);
                        $break=!self::evaluate(self::get($item,'after'),[$name,$item,$result],false) or $break;
                    }
                    catch(Exception $exc){
                        $break=!self::evaluate(self::get($item,'exception'),[$name,$item,$exc],true) or $break;
                        $break=!self::evaluate(self::get($options,'exception'),[$name,$item,$exc],true) or $break;
                    }
                }
            }

            $break=!self::evaluate(self::get($options,'after'),[$name,$item,$result],false) or $break;

            if($break){
                break;
            }
        }

        return($items);
    }

    static public function in($value,array $list=[]){
        return(array_search($value,$list)!==false);
    }

}