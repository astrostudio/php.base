<?php
namespace Base\Cache;

class PrefixCache extends ProxyCache
{
    private $prefix;

    public function __construct(string $prefix,CacheInterface $cache=null){
        parent::__construct($cache);

        $this->prefix=$prefix;
    }

    public function has(string $key):bool
    {
        return(parent::has($this->prefix.$key));
    }

    public function get(string $key){
        return(parent::get($this->prefix.$key));
    }

    public function set(string $key,$value){
        parent::set($this->prefix.$key,$value);
    }

    public function remove(string $key){
        parent::remove($this->prefix.$key);
    }
}
