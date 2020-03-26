<?php
namespace Base\Data;

use Base\Cache\CacheInterface;

class CacheData extends BaseData
{
    protected $_cache;
    protected $_key;

    public function __construct(CacheInterface $cache,string $key){
        $this->_cache=$cache;
        $this->_key=$key;
    }

    public function exists():bool
    {
        return($this->_cache->has($this->_key));
    }

    public function load(){
        return($this->_cache->get($this->_key));
    }

    public function save($data=null){
        return($this->_cache->set($this->_key,$data));
    }

    public function delete(){
        return($this->_cache->remove($this->_key));
    }
}
