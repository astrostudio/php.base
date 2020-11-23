<?php
namespace Base\Log;

class BasicLog extends LayerLog
{
    protected $_log;

    public function __construct(array $logs=[],LogInterface $log=null){
        parent::__construct($logs);

        $this->_log=new ProxyLog($log);
    }

    public function write(string $message=''){
        $this->_log->write($message);
    }
}
