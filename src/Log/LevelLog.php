<?php
namespace Base\Log;

class LevelLog extends LayerLog
{
    public function getLog($key):?LogInterface
    {
        return($this->_logs[$key]??null);
    }

    public function writeTo(string $name,string $message){
        if(!($log=$this->getLog($name))){
            return;
        }

        $log->write($message);
    }
}
