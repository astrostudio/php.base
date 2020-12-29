<?php
namespace Base\Logger;

class BasicLogger extends LevelLogger
{
    protected $_logger;

    public function __construct(array $loggers=[],LoggerInterface $logger=null,string $level=self::LEVEL){
        parent::__construct($loggers,$level);

        $this->_logger=$logger;
    }

    public function write(string $message,array $options=[]){
        if(!empty($options[$this->_level])){
            parent::write($message,$options);
        }
        else if($this->_logger){
            $this->_logger->write($message,$options);
        }
    }
}
