<?php
namespace Base\Repository;

use Base\Base;

class LayerRepository extends BaseRepository
{
    protected $_repositories=[];

    public function __construct(array $repositories=[]){
        $this->setRepository($repositories);
    }

    public function allows(string $id):bool
    {
        foreach($this->_repositories as $repository){
            if($repository->allows($id)){
                return(true);
            }
        }

        return(false);
    }

    public function has(string $id):bool
    {
        foreach($this->_repositories as $repository){
            if($repository->has($id)){
                return(true);
            }
        }

        return(false);
    }

    public function get(string $id,array $options=[]){
        if(!empty($options['repository'])){
            $repository=$this->getRepository($options['repository']);

            if(!$repository){
                return(null);
            }

            return($repository->get($id,Base::remove($options,['repository'])));
        }

        foreach($this->_repositories as $repository){
            if($repository->has($id)){
                return($repository->get($id));
            }
        }

        return(null);
    }

    public function set(string $id,$data=null,array $options=[]){
        foreach($this->_repositories as $repository){
            if($repository->allows($id)){
                return($repository->set($id,$data));
            }
        }

        return(false);
    }

    public function delete(string $id,array $options=[]){
        foreach($this->_repositories as $repository){
            if($repository->has($id)){
                return($repository->delete($id));
            }
        }

        return(false);
    }

    public function getRepository(string $key):?RepositoryInterface
    {
        return($this->_repositories[$key]??null);
    }

    public function setRepository($key,RepositoryInterface $repository=null,int $offset=null){
        if(is_array($key)){
            foreach($key as $k=>$r){
                $this->set($k,$r);
            }

            return;
        }

        unset($this->_repositories[$key]);

        if($repository){
            $this->_repositories=Base::insert($this->_repositories,$key,$repository,$offset);
        }
    }
}
