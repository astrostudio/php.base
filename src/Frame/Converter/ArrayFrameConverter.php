<?php
namespace Base\Frame\Converter;

use Base\Frame\BasicFrame;
use Base\Frame\FrameInterface;

class ArrayFrameConverter extends BaseFrameConverter
{
    public function convert($value):?FrameInterface
    {
        if(!is_array($value)){
            return(null);
        }

        return(new BasicFrame($value));
    }
}
