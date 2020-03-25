<?php
namespace Base\Repository;

class PrefixRepository extends ProxyRepository
{
    protected $_prefix;

    private function prefixed(string $id):bool
    {
        return(mb_substr($id,0,mb_strlen($this->_prefix))==$this->_prefix);
    }

    private function suffix(string $id):string
    {
        return(mb_substr($id,mb_strlen($this->_prefix)));
    }

    public function __construct(string $prefix='',RepositoryInterface $repository=null){
        parent::__construct($repository);

        $this->_prefix=$prefix;
    }

    public function allows(string $id):bool
    {
        return($this->prefixed($id));
    }

    public function has(string $id):bool
    {
        if(!$this->prefixed($id)){
            return(false);
        }

        return(parent::has($this->suffix($id)));
    }

    public function get(string $id,array $options=[]){
        if(!$this->prefixed($id)){
            return(null);
        }

        return(parent::get($this->suffix($id),$options));
    }

    public function set(string $id,$data=null,array $options=[]){
        if(!$this->prefixed($id)){
            return(false);
        }

        return(parent::set($this->suffix($id),$data,$options));
    }

    public function delete(string $id,array $options=[]){
        if(!$this->prefixed($id)){
            return(false);
        }

        return(parent::delete($this->suffix($id)));
    }


}
