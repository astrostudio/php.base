<?php
namespace Base\Repository;

class PathRepository extends BaseRepository
{
    protected $_dir;

    public function __construct(string $dir=null){
        $this->_dir=$dir;
    }

    public function allows(string $id):bool
    {
        return(true);
    }

    public function has(string $id):bool
    {
        return(file_exists($id));
    }

    public function get(string $id,array $options=[]){
        if(!$this->has($id)){
            return(null);
        }

        return(json_decode(file_get_contents($id),true));
    }

    public function set(string $id,$data=null,array $options=[]){
        return(file_put_contents($id,json_encode($data)));
    }

    public function delete(string $id,array $options=[]){
        return(unlink($id));
    }

}
