<?php
namespace Base\Cache;

class BasicCache extends BaseCache
{
    private $values=[];

    public function has(string $key):bool
    {
        return(isset($this->values[$key]));
    }

    public function get(string $key){
        return($this->values[$key]??null);
    }

    public function set(string $key,$value){
        $this->values[$key]=$value;
    }

    public function remove(string $key){
        unset($this->values[$key]);
    }
}
