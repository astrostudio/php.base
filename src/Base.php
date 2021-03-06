<?php
namespace Base;

use Exception;

class Base {

    static public function push(&$array,$item){
        if(!empty($item)){
            array_push($array,$item);
        }
    }

    static public function consume(array &$data,$key){
        $value=$data[$key]??null;

        unset($data[$key]);

        return($value);
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
            if(isset($arg)){
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

    static public function evaluate($var,array $params=[],$default=null){
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

    static public function leave(array $data=[],array $keys=[]){
        $result=[];

        foreach($keys as $key){
            if(array_key_exists($key,$data)){
                $result[$key]=$data[$key];
            }
        }

        return($result);
    }

    static public function remove(array $input,array $keys=[]){
        foreach($keys as $key){
            unset($input[$key]);
        }

        return($input);
    }

    static public function insert(array $input,$name,$item,int $offset=null):array
    {
        $count=count($input);
        $offset=$offset??$count;

        return(array_slice($input,0,$offset,true)+[$name=>$item]+array_slice($input,$offset,$count,true));
    }

    static public function cut(array $input=[],int $count=1):array
    {
        $rows=ceil(count($input)/$count);
        $chunks=array_chunk($input,$rows,true);
        $keys=[];
        $cuts=[];
        $c=count($chunks);

        for($i=0;$i<$c;++$i){
            $keys[$i]=array_keys($chunks[$i]);
        }

        $finish=false;
        $j=0;

        while(!$finish) {
            $finish=true;
            $cut[$j]=[];

            for ($i = 0; $i < $count; ++$i) {
                if(!empty($keys[$i])){
                    $key=array_shift($keys[$i]);
                    $cuts[$j][$key]=$chunks[$i][$key];
                    $finish=false;
                }
            }

            ++$j;
        }

        return($cuts);
    }

    static public function order(array $keys=[],int $from=0):array{
        $list=[];

        foreach($keys as $key=>$value){
            if(is_int($key)){
                $list[$value]=++$from;
            }
            else {
                $list[$key]=$value;
            }
        }

        return($list);
    }

    static public function sort(array &$input=[],array $order=[],int $value=null){
        return(usort($input,function($x1,$x2) use ($order,$value){
            $v1=isset($order[$x1])?$order[$x1]:$value;
            $v2=isset($order[$x2])?$order[$x2]:$value;

            if(!isset($v1)){
                if(!isset($v2)){
                    return(0);
                }

                return(1);
            }

            if(!isset($v2)){
                return(-1);
            }

            return($v1<=>$v2);
        }));
    }

}
