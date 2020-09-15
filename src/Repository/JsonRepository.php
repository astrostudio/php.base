<?php
namespace Base\Repository;

class JsonRepository extends ProxyRepository
{
    public function get(string $id,array $options=[]){
        return(json_decode(parent::get($id,$options),true));
    }

    public function set(string $id,$data=null,array $options=[]){
        return(parent::set($id,json_encode($data),$options));
    }
}
