<?php
namespace Base\Repository;

class FileRepository extends BaseRepository
{
    protected $_dir;

    protected function _path(string $id):string
    {
        return($this->_dir.DS.$id.'.json');
    }

    public function __construct(string $dir){
        $this->_dir=$dir;
    }

    public function allows(string $id):bool
    {
        return(true);
    }

    public function has(string $id):bool
    {
        return(file_exists($this->_path($id)));
    }

    public function get(string $id,array $options=[]){
        if(!$this->has($id)){
            return(null);
        }

        return(json_decode(file_get_contents($this->_path($id),true)));
    }

    public function set(string $id,$data=null,array $options=[]){
        return(file_put_contents($this->_path($id),json_decode($data)));
    }

    public function delete(string $id,array $options=[]){
        if(!$this->has($id)){
            return(false);
        }

        return(unlink($this->_path($id)));
    }
}
