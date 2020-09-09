<?php
namespace Base\Log;

class LayerLog extends BaseLog
{
    protected $_logs=[];

    public function __construct(array $logs=[]){
        $this->setLog($logs);
    }

    public function write(string $message){
        foreach($this->_logs as $log){
            $log->write($message);
        }
    }

    public function setLog($key,LogInterface $log=null){
        if(is_array($key)){
            foreach($key as $k=>$l){
                $this->setLog($k,$l);
            }

            return;
        }

        unset($this->_logs[$key]);

        if($log){
            $this->_logs[$key]=$log;
        }
    }
}
