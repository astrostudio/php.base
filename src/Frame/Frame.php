<?php
namespace Base\Frame;

class Frame
{
    static public function values(FrameInterface $frame,$key=null):array
    {
        if(is_string($key) or is_int($key)){
            $key=[$key];
        }
        else if(!isset($key)){
            $key=$frame->keys();
        }
        else if(!is_array($key)){
            return([]);
        }

        $values=[];

        foreach($key as $k){
            $values[$k]=$frame->get($k);
        }

        return($values);
    }


}
