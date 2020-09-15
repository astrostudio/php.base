<?php
namespace Base\Repository;

class FileRepository extends BaseRepository
{
    protected $_dir;
    protected $_ext;

    protected function _path(string $id):string
    {
        $path=$this->_dir.DS.$id;

        if(!empty($this->_ext)){
            $path.='.'.$this->_ext;
        }

        return($path);
    }

    public function __construct(string $dir,string $ext='json'){
        $this->_dir=$dir;
        $this->_ext=$ext;
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

        return(json_decode(file_get_contents($this->_path($id),true),true));
    }

    public function set(string $id,$data=null,array $options=[]){
        return(file_put_contents($this->_path($id),json_encode($data)));
    }

    public function delete(string $id,array $options=[]){
        if(!$this->has($id)){
            return(false);
        }

        return(unlink($this->_path($id)));
    }
}
