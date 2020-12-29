<?php
namespace Base\Logger;

use Base\Base;

class LayerLogger extends BaseLogger
{
    protected $_loggers=[];

    public function __construct(array $loggers=[]){
        $this->setLogger($loggers);
    }

    public function write(string $message,array $options=[]){
        foreach($this->_loggers as $logger){
            $logger->write($message,$options);
        }
    }

    public function writeTo($key,string $message,array $options=[]){
        if(is_array($key)){
            foreach($key as $k){
                $this->writeTo($k,$message,$options);
            }

            return;
        }

        if(!isset($this->_loggers[$key])){
            return;
        }

        $this->_loggers[$key]->write($message,$options);
    }

    public function writeWithTo($key,string $message,array $params=[],array $options=[]){
        $this->writeTo($key,Logger::with($message,$params),$options);
    }

    public function writeLineTo($key,array $items=[],array $options=[],string $delimiter=Logger::DELIMITER){
        $this->writeTo($key,Logger::line($items,$delimiter),$options);
    }

    public function writeJsonTo($key,$data,array $options=[]){
        $this->writeTo($key,json_encode($data),$options);
    }

    public function getLogger($key):?LoggerInterface
    {
        return($this->_loggers[$key]??null);
    }

    public function setLogger($key,LoggerInterface $logger=null,int $offset=null){
        if(is_array($key)){
            foreach($key as $k=>$l){
                $this->setLogger($k,$l);
            }

            return;
        }

        unset($this->_loggers[$key]);

        if($logger){
            $this->_loggers=Base::insert($this->_loggers,$key,$logger,$offset);
        }
    }
}
