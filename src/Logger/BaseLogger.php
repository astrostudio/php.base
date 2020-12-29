<?php
namespace Base\Logger;

abstract class BaseLogger implements LoggerInterface
{
    public function writeWith(string $message, array $params=[],array $options=[]){
        Logger::writeWith($this,$message,$params,$options);
    }

    public function writeLine(array $items=[],array $options=[],string $delimiter=Logger::DELIMITER){
        Logger::writeLine($this,$items,$options,$delimiter);
    }

    public function writeJson($data,array $options=[]){
        Logger::writeJson($this,$data,$options);
    }
}
