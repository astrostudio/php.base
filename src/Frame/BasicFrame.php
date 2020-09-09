<?php
namespace Base\Frame;

class BasicFrame extends BaseFrame
{
    use FrameTrait;

    public function __construct(array $values=[]){
        $this->set($values);
    }
}
