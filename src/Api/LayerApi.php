<?php
namespace Base\Api;

use Base\Layer;

class LayerApi extends BaseApi
{
    /** @var ApiInterface[] */
    protected $_apis=[];

    public function __construct(array $apis=[]){
        $this->setApi($apis);
    }

    public function has(string $action):bool
    {
        foreach($this->_apis as $api){
            if($api->has($action)){
                return(true);
            }
        }

        return(false);
    }

    public function execute(string $action,array $query=[]){
        foreach($this->_apis as $api){
            if($api->has($action)){
                return($api->execute($action,$query));
            }
        }

        return(null);
    }

    public function setApi($name,ApiInterface $api=null,int $offset=null){
        if(is_array($name)){
            foreach($name as $n=>$a){
                $this->setApi($n,$a);
            }

            return;
        }

        unset($this->_apis[$name]);

        if($api){
            $this->_apis=Layer::insert($this->_apis,$name,$api,$offset);
        }
    }
}
