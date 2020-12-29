<?php
namespace Base\Logger;

class ProxyLogger extends BaseLogger
{
    protected $_logger;

    public function __construct(LoggerInterface $logger=null){
        $this->_logger=$logger;
    }

    public function write(string $message,array $options=[]){
        if($this->_logger){
            $this->_logger->write($message,$options);
        }
    }
}
