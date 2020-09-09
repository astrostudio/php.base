<?php
namespace Base\Log;

abstract class BaseLog implements LogInterface
{
    public function logList(array $messages=[]){
        foreach($messages as $message){
            $this->write($message);
        }
    }
}
