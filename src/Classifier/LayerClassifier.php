<?php
namespace Base\Classifier;

class LayerClassifier implements ClassifierInterface {

    private $__classifiers=[];

    public function __construct(array $classifiers=[]){
        $this->setClassifier($classifiers);
    }

    public function is($subClassifier,$classifier){
        if(is_string($classifier)){
            $classifier=[$classifier];
        }

        foreach($classifier as $c){
            $is=false;

            foreach($this->__classifiers as $cc){
                if($cc->is($subClassifier,$c)){
                    $is=true;

                    break;
                }
            }

            if(!$is){
                return(false);
            }
        }

        return(true);
    }

    public function get($subClassifier){
        $classifiers=[];

        foreach($this->__classifiers as $classifier){
            $classifiers=array_merge($classifiers,$classifier->get($subClassifier));
        }

        return($classifiers);
    }

    public function has($classifier=null){
        $classifiers=[];

        foreach($this->__classifiers as $c){
            $classifiers=array_merge($classifiers,$c->has($classifier));
        }

        return($classifiers);
    }

    public function getClassifier($name){
        return(isset($this->__classifiers[$name])?$this->__classifiers[$name]:null);
    }

    public function setClassifier($name,ClassifierInterface $classifier=null){
        if(is_array($name)){
            foreach($name as $n=>$c){
                $this->setClassifier($n,$c);
            }

            return;
        }

        if(isset($classifier)){
            $this->__classifiers[$name]=$classifier;
        }
        else {
            unset($this->__classifiers[$name]);
        }
    }
}