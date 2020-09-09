<?php
namespace Base\Frame;

trait FrameTrait
{
    protected $_values=[];

    public function keys():array
    {
        return(array_keys($this->_values));
    }

    public function has($key):bool
    {
        return(array_key_exists($key,$this->_values));
    }

    public function get($key){
        return($this->_values[$key]??null);
    }

    public function set($key,$value=null){
        if(is_array($key)){
            foreach($key as $k=>$v){
                $this->set($k,$v);
            }

            return;
        }

        $this->_values[$key]=$value;
    }

    public function remove($key){
        if(is_array($key)){
            foreach($key as $k){
                $this->remove($k);
            }

            return;
        }

        unset($this->_values[$key]);
    }

    public function clear(){
        $this->remove($this->keys());
    }

}
