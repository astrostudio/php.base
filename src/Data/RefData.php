<?php
namespace Base\Data;

class RefData extends BaseData
{
    protected $_ref;

    public function __construct(&$data=null){
        $this->_ref=$data;
    }

    public function exists():bool
    {
        return(isset($this->_ref));
    }

    public function load(){
        return($this->_ref);
    }

    public function save($data=null)
    {
        $this->_ref=$data;
    }

    public function delete(){
        $this->_ref=null;
    }
}
