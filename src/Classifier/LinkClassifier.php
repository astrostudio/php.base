<?php
namespace Base\Classifier;

class LinkClassifier implements IClassifier {

    private $__classifier=[];

    private function __exists($pred,$succ,$item=false){
        if(isset($this->__classifier[$pred]) and isset($this->__classifier[$pred]['succ'][$succ])) {
            if($item) {
                return ($this->__classifier[$pred]['succ'][$succ]);
            }

            return(true);
        }

        return (false);
    }

    private function __check($pred,$succ){
        if($this->__exists($pred,$succ)){
            return(true);
        }

        if(isset($this->__classifier[$pred])) {
            foreach ($this->__classifier[$pred]['succ'] as $s => $item) {
                if (isset($this->__classifier[$s]['succ'][$succ])) {
                    return (true);
                }
            }
        }

        return(false);
    }

    private function __insert($classifier){
        if(!isset($this->__classifier[$classifier])){
            $this->__classifier[$classifier]=[
                'pred'=>[],
                'succ'=>[]
            ];
        }
    }

    private function __append($pred,$succ){
        if(!isset($this->__classifier[$pred])){
            $this->__insert($pred);
        }

        if(!isset($this->__classifier[$succ])){
            $this->__insert($succ);
        }

        $this->__classifier[$pred]['succ'][$succ]=$pred!=$succ;
        $this->__classifier[$succ]['pred'][$pred]=$pred!=$succ;

    }

    private function __extend($pred,$succ){
        if ($this->__check($succ, $pred)) {
            return (false);
        }

        $this->__append($pred,$succ);

        foreach($this->__classifier[$pred]['pred'] as $p=>$item){
            $this->__append($p,$succ);
        }

        foreach($this->__classifier[$succ]['succ'] as $s=>$item){
            $this->__append($pred,$s);
        }

        return(true);
    }

    public function is($subClassifier,$classifier){
        if(!isset($this->__classifier[$subClassifier])){
            return(false);
        }

        if(is_string($classifier)){
            if($subClassifier==$classifier){
                return(true);
            }

            return(isset($this->__classifier[$subClassifier]['pred'][$classifier]));
        }

        if(is_array($classifier)){
            foreach($classifier as $c){
                if(!(($subClassifier==$classifier) or $this->is($subClassifier,$c))){
                    return(false);
                }
            }

            return(true);
        }

        return(false);
    }

    public function get($subClassifier){
        if(!isset($this->__classifier[$subClassifier])){
            return([]);
        }

        return(array_keys($this->__classifier[$subClassifier]['pred']));
    }

    public function has($classifier=null){
        if(!isset($classifier)){
            return(array_keys($this->__classifier));
        }

        if(!isset($this->__classifier[$classifier])){
            return([]);
        }

        return(array_keys($this->__classifier[$classifier]['succ']));
    }

    public function set($subClassifier,$classifier=null) {
        if(isset($classifier)) {
            if (is_string($classifier)) {
                $this->__extend($classifier, $subClassifier);
            }

            if (is_array($classifier)) {
                $this->__insert($subClassifier);

                foreach ($classifier as $c) {
                    $this->__extend($c,$subClassifier);
                }
            }
        }
        else {
            $this->__insert($subClassifier);
        }
    }

}
