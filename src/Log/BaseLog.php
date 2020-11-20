<?php
namespace Base\Log;

abstract class BaseLog implements LogInterface
{
    public function writeList(array $messages=[]){
        foreach($messages as $message){
            $this->write($message);
        }
    }

    public function writeData($message=null,string $delimiter="\t",string $separator=': '){
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

            $this->write($line);
        }
        else {
            $this->write($message);
        }
    }

    public function writeJson($message){
        $this->write(json_encode($message));
    }
}
