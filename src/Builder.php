<?php
namespace Base;

class Builder {

    static private $__builders=[];

    static public function getBuilder($name){
        return(isset(self::$__builders[$name])?self::$__builders[$name]:null);
    }

    static public function setBuilder($name,IBuilder $builder=null){
        if(is_array($name)){
            foreach($name as $n=>$b){
                self::setBuilder($n,$b);
            }

            return;
        }

        if(isset($builder)){
            self::$__builders[$name]=$builder;
        }
        else {
            unset(self::$__builders[$name]);
        }
    }

}