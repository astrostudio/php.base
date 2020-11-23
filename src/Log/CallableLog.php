<?php
namespace Base\Log;

class CallableLog extends BaseLog
{
    protected $_callable;

    public function __construct(callable $callable){
        $this->_callable=$callable;
    }

    public function write(string $message){
        call_user_func($this->_callable,$message);
    }
}
