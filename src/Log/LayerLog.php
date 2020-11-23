<?php
namespace Base\Log;

class LayerLog extends BaseLog
{
    const DELIMITER=',';

    protected $_logs=[];
    protected $_delimiter;

    private function keys($key):array
    {
        if(is_array($key)){
            return($key);
        }

        return(explode($this->_delimiter,$key));
    }

    public function __construct(array $logs=[],string $delimiter=self::DELIMITER){
        $this->setLog($logs);

        $this->_delimiter=$delimiter;
    }

    public function write(string $message){
        foreach($this->_logs as $log){
            $log->write($message);
        }
    }

    public function getLog($key):?LogInterface
    {
        return($this->_logs[$key]??null);
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

    public function writeTo($key,string $message=''){
        $keys=$this->keys($key);

        foreach($keys as $k){
            if(!($log=$this->getLog($k))){
                continue;
            }

            $log->write($message);
        }
    }

    public function writeListTo($key,array $messages=[])
    {
        foreach($messages as $message){
            $this->writeTo($key,$message);
        }
    }

    public function writeDataTo($key,$message=null,string $delimiter="\t",string $separator=': '){
        if(is_array($message)){
            $line='';
            $d='';

            foreach($message as $k=>$subMessage){
                $line.=$d;

                if(is_int($k)){
                    $line.=$subMessage;
                }
                else {
                    $line.=$k.$separator.$subMessage;
                }

                $d=$delimiter;
            }

            $this->writeTo($key,$line);
        }
        else {
            $this->writeTo($key,$message);
        }
    }

    public function writeJsonTo($key,$message){
        $this->writeTo($key,json_encode($message));
    }

}
