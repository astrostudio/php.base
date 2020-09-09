<?php
namespace Base\Frame\Converter;

use Base\Frame\FrameInterface;

class SelfFrameConverter extends BaseFrameConverter
{
    public function convert($value):?FrameInterface
    {
        if(!($value instanceof FrameInterface)){
            return(null);
        }

        return($value);
    }
}
