<?php
namespace Base\Api;

class MethodApi extends BaseApi
{
    public function has(string $action):bool
    {
        return(method_exists($this,$action));
    }

    public function execute(string $action,array $query=[]){
        if(!method_exists($this,$action)){
            return(null);
        }

        return($this->$action($query));
    }
}
