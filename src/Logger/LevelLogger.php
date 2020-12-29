<?php
namespace Base\Logger;

class LevelLogger extends LayerLogger
{
    const LEVEL='level';

    protected $_level;

    public function __construct(array $loggers=[],string $level=self::LEVEL){
        parent::__construct($loggers);

        $this->_level=$level;
    }

    public function write(string $message,array $options=[]){
        if(!empty($options[$this->_level])){
            $this->writeTo($options[$this->_level],$message,$options);
        }
    }
}
