<?php
namespace Base\Api\Action;

use Base\Api\ApiActionInterface;

class ProxyApiAction extends BaseApiAction
{
    protected $_action;
    protected $_query;

    public function __construct(ApiActionInterface $action=null,array $query=[]){
        $this->_action=$action;
        $this->_query=$query;
    }

    public function execute(array $query=[]){
        return($this->_action?$this->_action->execute(array_merge($this->_query,$query)):null);
    }
}
