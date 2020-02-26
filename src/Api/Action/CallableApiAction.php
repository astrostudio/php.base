<?php
namespace Base\Api\Action;

class CallableApiAction extends BaseApiAction
{
    protected $_callable;

    public function __construct(callable $callable){
        $this->_callable=$callable;
    }

    public function execute(array $query=[]){
        return(call_user_func($this->_callable,$query));
    }
}
