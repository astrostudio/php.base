<?php
namespace Base\Api;

class ProxyApi extends BaseApi
{
    protected $_api;

    public function __construct(ApiInterface $api=null){
        $this->_api=$api;
    }

    public function actions():array
    {
        return($this->_api?$this->_api->actions():[]);
    }

    public function has(string $action):bool
    {
        return($this->_api?$this->_api->has($action):false);
    }

    public function execute(string $action,array $query=[]){
        return($this->_api?$this->_api->execute($action,$query):null);
    }
}
