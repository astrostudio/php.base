<?php
namespace Base\Data;

class BasicData extends BaseData
{
    protected $_data;

    public function __construct($data=null){
        $this->_data=$data;
    }

    public function exists():bool
    {
        return(isset($this->_data));
    }

    public function load(){
        return($this->_data);
    }

    public function save($data=null){
        $this->_data=$data;
    }

    public function delete(){
        $this->_data=null;
    }


}
