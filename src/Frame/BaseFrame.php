<?php
namespace Base\Frame;

abstract class BaseFrame implements FrameInterface
{
    public function isEmpty():bool
    {
        return(count($this->keys())==0);
    }

    public function values($key=null):array{
        return(Frame::values($this,$key));
    }

    public function toArray():array
    {
        return($this->values());
    }

    public function jsonSerialize(){
        return($this->toArray());
    }

}
