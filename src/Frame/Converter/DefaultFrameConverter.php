<?php
namespace Base\Frame\Converter;

class DefaultFrameConverter extends LayerFrameConverter
{
    public function __construct(){
        parent::__construct([
            'self'=>new SelfFrameConverter(),
            'array'=>new ArrayFrameConverter(),
            'json'=>new JsonFrameConverter()
        ]);
    }
}
