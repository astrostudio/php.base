<?php
namespace Base;

use Exception;

class XML {

    static public function options(array $options=[]):string{
        $output='';

        foreach($options as $name=>$value){
            $output.=' '.$name.'="'.$value.'"';
        }

        return($output);
    }

    static public function simple(string $name,array $options= []):string{
        return('<'.$name.self::options($options).'/>');
    }

    static public function node(string $name,array $options= [],string $content=null):string{
        return('<'.$name.self::options($options).'>'.($content??'').'</'.$name.'>');
    }

    private $stack= [];

    public function start(string $name,array $options= []):string{
        array_push($this->stack,$name);

        return('<'.$name.self::options($options).'>');
    }

    public function end():string{
        if(empty($this->stack)){
            throw new Exception('XML::end: Empty stack');
        }

        $name=array_pop($this->stack);

        return('</'.$name.'>');
    }

    public function element(string $name,array $options= [],string $content=null):string{
        $output=$this->start($name,$options);

        if(isset($content)){
            $output.=$content;
            $output.=$this->end();
        }

        return($output);
    }

    public function check(){
        if(!empty($this->stack)){
            throw new Exception('XML::check: Stack not empty');
        }
    }

}
