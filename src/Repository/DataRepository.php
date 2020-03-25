<?php
namespace Base\Repository;

use Base\Data\DataInterface;

class DataRepository extends BaseRepository
{
    protected $_data=[];

    public function __construct(array $data=[]){
        $this->setData($data);
    }

    public function allows(string $id):bool
    {
        return(true);
    }

    public function has(string $id):bool{
        return(isset($this->_data[$id]));
    }

    public function get(string $id,array $options=[]){
        return(isset($this->_data[$id])?$this->_data[$id]->load():null);
    }

    public function set(string $id,$data=null,array $options=[])
    {
        if(!isset($this->_data[$id])){
            return(false);
        }

        return($this->_data[$id]->save($data));
    }

    public function delete(string $id,array $options=[])
    {
        if(!isset($this->_data[$id])){
            return(false);
        }

        return($this->_data[$id]->deleet());
    }

    public function setData($id,DataInterface $data=null){
        if(is_array($id)){
            foreach($id as $i=>$d){
                $this->setData($i,$d);
            }

            return;
        }

        unset($this->_data[$id]);

        if($data){
            $this->_data[$id]=$data;
        }
    }
}
