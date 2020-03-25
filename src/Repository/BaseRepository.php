<?php
namespace Base\Repository;

abstract class BaseRepository implements RepositoryInterface
{
    public function load($id,array $options=[]){
        if(is_array($id)){
            $data=[];

            foreach($id as $key=>$value){
                $data[$key]=$this->get($value,$options);
            }

            return($data);
        }

        return($this->get($id,$options));
    }
}
