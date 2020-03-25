<?php
namespace Base\Data;

use Base\Data;
use Base\Repository\RepositoryInterface;

class RepositoryData extends Data
{
    protected $_repository;
    protected $_id;

    public function __construct(RepositoryInterface $repository,string $id){
        $this->_repository=$repository;
        $this->_id=$id;
    }

    public function exsists():bool
    {
        return($this->_repository->has($this->_id));
    }

    public function load(){
        return($this->_repository->get($this->_id));
    }

    public function save($data=null){
        return($this->_repository->set($this->_id,$data));
    }

    public function delete(){
        return($this->_repository->delete($this->_id));
    }


}
