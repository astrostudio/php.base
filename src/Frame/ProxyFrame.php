<?php
namespace Base\Frame;

class ProxyFrame extends BaseFrame
{
    protected $_frame;

    public function __construct(FrameInterface $frame=null){
        $this->_frame=$frame;
    }

    public function keys():array
    {
        return($this->_frame?$this->_frame->keys():[]);
    }

    public function has($key):bool
    {
        return($this->_frame?$this->_frame->has($key):false);
    }

    public function get($key){
        return($this->_frame?$this->_frame->get($key):null);
    }
}
