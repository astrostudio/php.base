<?php
namespace Base\Log;

class LevelLog extends LayerLog
{
    const DELIMITER=',';

    protected $_delimiter;

    public function __construct(array $logs=[],string $delimiter=self::DELIMITER){
        parent::__construct($logs);

        $this->_delimiter=$delimiter;
    }

    private function names($name):array
    {
        if(is_array($name)){
            return($name);
        }

        $names=explode($this->_delimiter,$name);

        return($names);
    }

    public function getLog($key):?LogInterface
    {
        return($this->_logs[$key]??null);
    }

    public function writeTo($name,string $message){
        $names=$this->names($name);

        foreach($names as $n) {
            if (!($log = $this->getLog($n))) {
                continue;
            }

            $log->write($message);
        }
    }

    public function writeListTo($name,array $messages=[])
    {
        foreach($messages as $message){
            $this->writeTo($name,$message);
        }
    }

    public function writeDataTo($name,$message=null,string $delimiter="\t",string $separator=': '){
        if(is_array($message)){
            $line='';
            $d='';

            foreach($message as $key=>$subMessage){
                $line.=$d;

                if(is_int($key)){
                    $line.=$subMessage;
                }
                else {
                    $line.=$key.$separator.$subMessage;
                }

                $d=$delimiter;
            }

            $this->writeTo($name,$line);
        }
        else {
            $this->writeTo($name,$message);
        }
    }

    public function writeJsonTo($name,$message){
        $this->writeTo($name,json_encode($message));
    }

}
