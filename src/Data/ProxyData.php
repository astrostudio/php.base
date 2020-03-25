<?php
namespace Base\Data;

use Base\Data;

class ProxyData extends Data
{
    protected $_data;

    public function __construct(DataInterface $data=null){
        $this->_data=$data;
    }

    public function exists():bool
    {
        return($this->_data?$this->_data->exists():false);
    }

    public function load(){
        return($this->_data?$this->_data->load():null);
    }

    public function save($data=null){
        if(!$this->_data){
            return(false);
        }

        return($this->_data->save($data));
    }
}
