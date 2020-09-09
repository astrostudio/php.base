<?php
namespace Base\Frame\Converter;

use Base\Frame\FrameConverterInterface;

abstract class BaseFrameConverter implements FrameConverterInterface
{
    public function convertList(array $values=[]):array {
        $frames=[];

        foreach($values as $key=>$value){
            if(($frame=$this->convert($value))){
                $frames[$key]=$frame;
            }
        }

        return($frames);
    }
}
