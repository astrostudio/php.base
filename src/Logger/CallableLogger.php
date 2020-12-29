<?php
namespace Base\Logger;

class CallableLogger extends BaseLogger
{
    protected $_callable;

    public function __construct(callable $callable){
        $this->_callable=$callable;
    }

    public function write(string $message,array $options=[]){
        call_user_func($this->_callable,$message,$options);
    }
}
