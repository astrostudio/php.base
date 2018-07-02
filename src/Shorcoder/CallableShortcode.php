<?php
namespace Base\Shortcoder;

class CallableShortcode extends BaseShortcode {

    private $__callable=null;

    public function __construct(callable $callable){
        $this->__callable=$callable;
    }

    protected function _process(array $params=[],$body=null){
        return(call_user_func($this->__callable,$this,$params,$body));
    }

}