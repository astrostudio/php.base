<?php
namespace Base\Shortcoder;

class TemplateShortcoder extends BaseShortcode {

    private $__delimiter=null;
    private $__template=null;

    public function __construct($template='',$delimiter='%'){
        $this->__delimiter=$delimiter;
        $this->__template=$template;
    }

    protected function _process(array $params=[],$body=null){
        $template=$this->__template;

        if(isset($body)){
            $template=str_replace($this->__delimiter.'BODY'.$this->__delimiter,$body,$template);
        }

        foreach($params as $name=>$value){
            $template=str_replace($this->__delimiter.mb_strtoupper($name).$this->__delimiter,$value,$template);
        }

        return($template);
    }

}