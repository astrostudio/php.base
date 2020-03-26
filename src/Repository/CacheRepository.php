<?php
namespace Base\Repository;

use Base\Cache\CacheInterface;

class CacheRepository extends BaseRepository
{
    protected $_cache;

    public function __construct(CacheInterface $cache){
        $this->_cache=$cache;
    }

    public function allows(string $id):bool
    {
        return(true);
    }

    public function has(string $id):bool{
        return($this->_cache->has($id));
    }

    public function get(string $id,array $options=[])
    {
        return($this->_cache->get($id));
    }

    public function set(string $id,$data=null,array $options=[]){
        return($this->_cache->set($id,$data));
    }

    public function delete(string $id,array $options=[])
    {
        return($this->_cache->remove($id));
    }

}
