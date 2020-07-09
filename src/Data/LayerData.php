<?php
namespace Base\Data;

use Base\Data;

class LayerData extends Data
{
    protected $_items=[];

    public function __construct(array $items=[]){
        $this->set($items);
    }

    public function exists():bool
    {
        foreach($this->_items as $item){
            if(!$item->exists()){
                return(false);
            }
        }

        return(true);
    }

    public function load()
    {
        $data=[];

        foreach($this->_items as $key=>$item){
            $data[$key]=$item->load();
        }

        return($data);
    }

    public function save($data=null)
    {
        if(!is_array($data)){
            return(false);
        }

        $result=[];

        foreach($data as $key=>$item){
            if(isset($this->_items[$key])){
                $result[$key]=$item->save($data[$key]);
            }
        }

        return($result);
    }


    public function delete(){
        $result=[];

        foreach($this->_items as $key=>$item){
            $result[$key]=$item->delete();
        }

        return($result);
    }

    public function get($key):?DataInterface
    {
        return($this->_items[$key]??null);
    }

    public function set($key,DataInterface $data=null){
        if(is_array($key)){
            foreach($key as $k=>$d){
                $this->set($k,$d);
            }

            return;
        }

        unset($this->_items[$key]);

        if($data){
            $this->_items[$key]=$data;
        }
    }

}
