<?php
namespace Base\Log;

class ProxyLog extends BaseLog
{
    protected $_log;

    public function __construct(LogInterface $log=null){
        $this->_log=$log;
    }

    public function write(string $message){
        if($this->_log){
            $this->_log->write($message);
        }
    }
}
