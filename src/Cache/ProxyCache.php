<?php
namespace Base\Cache;

class ProxyCache extends BaseCache
{
    private $cache;

    public function __construct(CacheInterface $cache=null){
        $this->cache=$cache;
    }

    public function has(string $key):bool
    {
        return($this->cache?$this->cache->has($key):false);
    }

    public function get(string $key){
        return($this->cache?$this->cache->get($key):null);
    }

    public function set(string $key,$value){
        if($this->cache){
            $this->cache->set($key,$value);
        }
    }

    public function remove(string $key){
        if($this->cache){
            $this->cache->remove($key);
        }
    }
}
