<?php
namespace Base\Log;

class FileLog extends BaseLog
{
    protected $_path;

    public function __construct(string $path){
        $this->_path=$path;
    }

    public function write(string $message){
        file_put_contents($this->_path,$message."\n",FILE_APPEND);
    }
}