<?php
namespace Base\Api;

class BasicApi extends BaseApi
{
    protected $_actions=[];

    public function __construct(array $actions=[]){
        $this->setAction($actions);
    }

    public function has(string $action):bool
    {
        return(isset($this->actions[$action]));
    }

    public function execute(string $action,array $query=[]){
        return(isset($this->_actions[$action])?$this->_actions[$action]->execute($query):null);
    }

    public function setAction($name,ApiActionInterface $action=null){
        if(is_array($name)){
            foreach($name as $n=>$a){
                $this->setAction($n,$a);
            }

            return;
        }

        unset($this->_actions[$name]);

        if($action){
            $this->_actions[$name]=$action;
        }
    }

}
