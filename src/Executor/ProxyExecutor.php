<?php
namespace Base\Executor;

class ProxyExecutor extends BaseExecutor
{
    protected $_executor;

    public function __construct(ExecutorInterface $executor=null){
        $this->_executor=$executor;
    }

    public function execute(string $cmd)
    {
        return($this->_executor?$this->_executor->execute($cmd):null);
    }

    public function launch(string $cmd):?int
    {
        return($this->_executor?$this->_executor->launch($cmd):null);
    }

    public function kill(int $pid){
        return($this->_executor?$this->_executor->kill($pid):false);
    }
}
