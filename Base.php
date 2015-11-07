<?php
namespace Base;

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
    
}