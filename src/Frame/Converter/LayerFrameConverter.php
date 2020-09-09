<?php
namespace Base\Frame\Converter;

use Base\Base;
use Base\Frame\FrameConverterInterface;
use Base\Frame\FrameInterface;

class LayerFrameConverter extends BaseFrameConverter
{
    protected $_converters=[];

    public function __construct(array $converters=[]){
        $this->setConverter($converters);
    }

    public function convert($value):?FrameInterface
    {
        foreach($this->_converters as $converter){
            if(($frame=$converter->convert($value))){
                return($frame);
            }
        }

        return(null);
    }

    public function setConverter($key,FrameConverterInterface $converter=null,int $offset=null){
        if(is_array($key)){
            foreach($key as $k=>$c){
                $this->setConverter($k,$c);
            }

            return;
        }

        unset($this->_converters[$key]);

        if($converter){
            $this->_converters=Base::insert($this->_converters,$key,$converter,$offset);
        }
    }
}
