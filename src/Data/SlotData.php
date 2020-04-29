<?php
namespace Base\Data;

use Base\Data;

class SlotData extends ProxyData
{
    public function setData(DataInterface $data=null){
        $this->_data=$data;
    }
}
