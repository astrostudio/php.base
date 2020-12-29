<?php
namespace Base\Logger;

class FileLogger extends BaseLogger
{
    protected $_path;
    protected $_size;
    protected $_rotate;

    protected function _rename(){
        if(!file_exists($this->_path)){
            return;
        }

        rename($this->_path,$this->_path.'.'.date('YmdHis'));
    }

    protected function _rotate(){
        if($this->_rotate<=0){
            return;
        }

        $files = glob($this->_path . '.*');

        if(empty($files)){
            return;
        }

        $count=count($files)-$this->_rotate;

        while(!empty($files) and ($count-->0)){
            unlink(array_shift($files));
        }
    }

    protected function _update(){
        if(!$this->_size>0){
            return;
        }

        if(!file_exists($this->_path)){
            return;
        }

        if(filesize($this->_path)<$this->_size){
            return;
        }

        $this->_rename();
        $this->_rotate();
    }

    public function __construct(string $path,int $size=0,int $rotate=0){
        $this->_path=$path;
        $this->_size=$size;
        $this->_rotate=$rotate;
    }

    public function write(string $message,array $options=[]){
        $this->_update();

        file_put_contents($this->_path,$message."\n",FILE_APPEND);
    }

}
