<?php
namespace Base\Repository;

class ProxyRepository extends BaseRepository
{
    protected $_repository;

    public function __construct(RepositoryInterface $repository=null){
        $this->_repository=$repository;
    }

    public function allows(string $id):bool {
        return($this->_repository?$this->_repository->allows($id):false);
    }

    public function has(string $id):bool
    {
        return($this->_repository?$this->_repository->has($id):false);
    }

    public function get(string $id,array $options=[]){
        return($this->_repository?$this->_repository->get($id,$options):null);
    }

    public function set(string $id,$data=null,array $options=[]){
        return($this->_repository?$this->_repository->set($id,$data,$options):false);
    }

    public function delete(string $id,array $options=[]){
        return($this->_repository?$this->_repository->delete($id,$options):false);
    }

}
