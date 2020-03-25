<?php
namespace Base\Data;

class JsonData extends BaseData
{
    protected $_path;

    public function __construct(string $path){
        $this->_path=$path;
    }

    public function exists():bool
    {
        return(is_file($this->_path));
    }

    public function load(){
        return(json_decode(file_get_contents($this->_path),true));
    }

    public function save($data=null){
        return(file_put_contents($this->_path,json_encode($data)));
    }

    public function delete(){
        return(unlink($this->_path));
    }

}
