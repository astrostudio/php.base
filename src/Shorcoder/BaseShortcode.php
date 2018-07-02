<?php
namespace Base\Shortcoder;

abstract class BaseShortcode implements IShortcode {

    public function process(array $params=[],$body=null){
        return($this->_process($params,$body));
    }

    abstract protected function _process(array $params=[],$body=null);

}