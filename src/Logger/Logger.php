<?php
namespace Base\Logger;

class Logger
{
    const DELIMITER="\t";

    static public function with(string $message,array $params=[]):string{
        foreach($params as $key=>$value){
            $message=str_replace('{'.$key.'}',$value,$message);
        }

        return($message);
    }

    static public function line(array $items=[],string $delimiter=self::DELIMITER):string
    {
        $d='';
        $line='';

        foreach($items as $key=>$message){
            $line.=$d;
            $line.=$message;
        }

        return($line);
    }


    static public function writeWith(LoggerInterface $logger,string $message,array $params=[],array $options=[]){
        $logger->write(self::with($message,$params),$options);
    }

    static public function writeLine(LoggerInterface $logger,array $items=[],array $options=[],string $delimiter=self::DELIMITER){
        $logger->write(self::line($items,$delimiter),$options);
    }

    static public function writeJson(LoggerInterface $logger,$data,array $options=[]){
        $logger->write(json_encode($data),$options);
    }

}
