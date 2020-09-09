<?php
namespace Base\Frame\Converter;

use Base\Frame\FrameInterface;

class JsonFrameConverter extends ArrayFrameConverter
{
    public function convert($value):?FrameInterface
    {
        if(!is_string($value)){
            return(null);
        }

        $array=json_decode($value,true);

        if(!$array){
            return(null);
        }

        return(parent::convert($array));
    }
}
