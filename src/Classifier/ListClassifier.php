<?php
namespace Base\Classifier;

class ListClassifier implements IClassifier {

    private $__classifier=null;
    private $__item=[];

    public function __construct(IClassifier $classifier=null){
        $this->__classifier=$classifier;
        $this->__item=[];
    }

    public function is($subClassifier,$classifier){
        if(!$this->__classifier){
            return(false);
        }

        if(!isset($this->__item[$subClassifier])){
            return(false);
        }

        foreach($this->__item[$subClassifier] as $c){
            if($this->__classifier->is($c,$classifier)){
                return(true);
            }
        }

        return(false);
    }

    public function get($subClassifier){
        if(!$this->__classifier){
            return([]);
        }

        if(!isset($this->__item[$subClassifier])){
            return([]);
        }

        $classifiers=[];

        foreach($this->__item[$subClassifier] as $c){
            $classifiers[]=$c;
            $classifiers=array_merge($classifiers,$this->__classifier->get($c));
        }

        return($classifiers);
    }

    public function has($classifier=null){
        if(!isset($classifier)){
            return(array_keys($this->__item));
        }

        $classifier=is_string($classifier)?[$classifier]:$classifier;
        $items=[];

        foreach($this->__item as $name=>$c){
            if(count(array_intersect($c,$classifier))){
                $items[]=$name;
            }
            else  if($this->is($name,$classifier)){
                $items[]=$name;
            }
        }

        return($items);
    }

    public function set($name,$classifier=null){
        if(isset($classifier)) {
            if (is_string($classifier)) {
                $this->__item[$name] = [$classifier];
            } else if (is_array($classifier)) {
                $this->__item[$name] = $classifier;
            }
        }
        else {
            $this->__item[$name]=[];
        }
    }

}