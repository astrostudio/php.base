<?php
namespace Base\Relation;

use Base\Base;

class LinkRelation extends BaseRelation {

    const CYCLES='cycles';
    const TRANSITION='transition';
    const UP='up';
    const DOWN='down';
    const IDENTITY='identity';
    const OPTIONS=[
        self::CYCLES=>false,
        self::TRANSITION=>true,
        self::UP=>false,
        self::DOWN=>false,
        self::IDENTITY=>false
    ];
    const LINK=[
        self::TRANSITION=>false
    ];
    const ONTOLOGY=[
        self::UP=>true,
        self::DOWN=>true,
        self::IDENTITY=>true
    ];

    protected $_links=[];
    protected $_options=[];

    public function __construct(array $list=[],array $options=[]){
        $this->_options=Base::extend(self::OPTIONS,$options);

        $this->appendList($list);
    }

    public function isA($subConcept,$concept): bool{
        if(!is_string($subConcept) and !is_int($subConcept) and !is_string($concept) and !is_int($concept)){
            return(false);
        }

        return($this->exists($concept,$subConcept));
    }

    public function exists($pred,$succ,$item=false){
        if(isset($this->_links[$pred]) and isset($this->_links[$pred]['succ'][$succ])) {
            if($item) {
                return ($this->_links[$pred]['succ'][$succ]);
            }

            return(true);
        }

        return (false);
    }

    public function check($pred,$succ,$transition=true){
        if($this->exists($pred,$succ)){
            return(true);
        }

        if($transition){
            if(isset($this->_links[$pred])) {
                foreach ($this->_links[$pred]['succ'] as $s => $item) {
                    if (isset($this->_links[$s]['succ'][$succ])) {
                        return (true);
                    }
                }
            }
        }

        return(false);
    }

    private function __append($pred,$succ){
        if(!isset($this->_links[$pred])){
            $this->_links[$pred]=['pred'=>[],'succ'=>[]];
        }

        if(!isset($this->_links[$succ])){
            $this->_links[$succ]=['pred'=>[],'succ'=>[]];
        }

        $this->_links[$pred]['succ'][$succ]=$pred!=$succ;
        $this->_links[$succ]['pred'][$pred]=$pred!=$succ;
    }

    public function append($pred,$succ,array $options=[]){
        $options = array_merge($this->_options,$options);

        if (!$options[self::CYCLES]) {
            if ($this->check($succ, $pred, $options[self::TRANSITION])) {
                return (false);
            }
        }

        if($options[self::IDENTITY]){
            if($pred!=$succ){
                $this->__append($pred,$pred);
                $this->__append($succ,$succ);
            }
        }

        $this->__append($pred,$succ);

        if($options[self::UP]){
            if($options[self::DOWN]){
                $this->extend($pred,$succ);
            }
            else {
                $this->extendUp($pred,$succ);
            }
        }
        else if($options[self::DOWN]){
            $this->extendDown($pred,$succ);
        }

        return(true);
    }

    public function appendList(array $list=[],array $options=[]){
        foreach($list as $pair){
            if(!isset($pair[0]) and isset($pair[1])){
                $this->append($pair[0],$pair[1],$options);
            }
        }
    }

    public function appendPred(array $list=[],array $options=[]){
        foreach($list as $succ=>$preds){
            foreach($preds as $pred){
                $this->append($pred,$succ,$options);
            }
        }
    }

    private function __remove($pred,$succ){
        if(isset($this->_links[$pred])){
            if(isset($this->_links[$pred]['succ'][$succ])){
                unset($this->_links[$pred]['succ'][$succ]);
            }
        }

        if(isset($this->_links[$succ])){
            if(isset($this->_links[$succ]['pred'][$pred])){
                unset($this->_links[$succ]['pred'][$pred]);
            }
        }
    }

    public function remove($pred,$succ,array $options=[]){
        $options=array_merge($this->_options,$options);

        if($options[self::UP]){
            if($options[self::DOWN]){
                $this->shrink($pred,$succ);
            }
            else{
                $this->shrinkUp($pred,$succ);
            }
        }
        else if($options[self::DOWN]){
            $this->shrinkDown($pred,$succ);
        }

        $this->__remove($pred,$succ);
    }

    private function __extend($pred,$succ){
        if(!isset($this->_links[$pred])){
            $this->_links[$pred]=['pred'=>[],'succ'=>[]];
        }

        if(!isset($this->_links[$succ])){
            $this->_links[$succ]=['pred'=>[],'succ'=>[]];
        }

        $this->_links[$pred]['succ'][$succ]=!empty($this->_links[$pred]['succ'][$succ]);
        $this->_links[$succ]['pred'][$pred]=!empty($this->_links[$succ]['pred'][$pred]);
    }

    public function extendUp($pred,$succ){
        $this->__append($pred,$succ);

        foreach($this->_links[$pred]['pred'] as $p=>$item){
            $this->__extend($p,$succ);
        }
    }

    public function extendDown($pred,$succ){
        $this->__append($pred,$succ);

        foreach($this->_links[$succ]['succ'] as $s=>$item){
            $this->__extend($pred,$s);
        }
    }

    public function extend($pred,$succ){
        $this->extendUp($pred,$succ);
        $this->extendDown($pred,$succ);
    }

    public function extendAll(){
        foreach($this->_links as $pred=>$data){
            foreach($data['succ'] as $succ=>$item){
                $this->extend($pred,$succ);
            }
        }
    }

    private function __shrink($pred,$succ){
        if(isset($this->_links[$pred])){
            if(isset($this->_links[$pred]['succ'][$succ])){
                if(!$this->_links[$pred]['succ'][$succ]){
                    unset($this->_links[$pred]['succ'][$succ]);
                }
            }
        }

        if(isset($this->_links[$succ])){
            if(isset($this->_links[$succ]['pred'][$pred])){
                if(!$this->_links[$succ]['pred'][$pred]){
                    unset($this->_links[$succ]['pred'][$pred]);
                }
            }
        }
    }

    public function shrinkUp($pred,$succ){
        $this->__append($pred,$succ);

        foreach($this->_links[$pred]['pred'] as $p=>$item){
            $this->__shrink($p,$succ);
        }
    }

    public function shrinkDown($pred,$succ){
        $this->__append($pred,$succ);

        foreach($this->_links[$succ]['succ'] as $s=>$item){
            $this->__shrink($pred,$s);
        }
    }

    public function shrink($pred,$succ){
        $this->shrinkUp($pred,$succ);
        $this->shrinkDown($pred,$succ);
    }

    public function shrinkAll(){
        foreach($this->_links as $pred=>$data){
            foreach($data['succ'] as $succ=>$item){
                $this->__shrink($pred,$succ);
            }
        }
    }

    public function root($key=null){
        $roots=[];

        if(!empty($key)){
            if(isset($this->_links[$key])){
                foreach($this->_links[$key]['pred'] as $pred=>$item){
                    if(empty($this->_links[$pred]['pred'])){
                        $roots[]=$pred;
                    }
                }
            }

            return($roots);
        }

        foreach($this->_links as $pred=>$data){
            if(empty($data['pred'])){
                $roots[]=$pred;
            }
        }

        return($roots);
    }

    public function pred($key){
        return(!empty($this->_links[$key])?$this->_links[$key]['pred']:[]);
    }

    public function succ($key){
        return(!empty($this->_links[$key])?$this->_links[$key]['succ']:[]);
    }

    public function down($key=null){
        $succs=[];

        if(!empty($key)){
            if(empty($this->_links[$key])){
                return($succs);
            }

            foreach($this->_links[$key]['succ'] as $succ=>$item){
                if($item) {
                    $succs[$succ] = $this->down($succ);
                }
            }

            return($succs);
        }

        $roots=$this->root();

        foreach($roots as $root){
            $succs[$root]=$this->down($root);
        }

        return($succs);
    }

    public function leaf($key=null){
        $leafs=[];

        if(!empty($key)){
            if(isset($this->_links[$key])){
                foreach($this->_links[$key]['succ'] as $succ=>$item){
                    if(empty($this->_links[$succ]['succ'])){
                        $leafs[]=$succ;
                    }
                }
            }

            return($leafs);
        }

        foreach($this->_links as $pred=>$data){
            if(empty($data['succ'])){
                $leafs[]=$pred;
            }
        }

        return($leafs);
    }


    public function up($key=null){
        $preds=[];

        if(!empty($key)){
            if(empty($this->_links[$key])){
                return($preds);
            }

            foreach($this->_links[$key]['pred'] as $pred=>$item){
                if($item) {
                    $preds[$pred] = $this->up($pred);
                }
            }

            return($preds);
        }

        $leafs=$this->leaf();

        foreach($leafs as $leaf){
            $preds[$leaf]=$this->up($leaf);
        }

        return($preds);
    }

    public function siblings($key){
        $siblings=[];

        if(!isset($this->_links[$key])){
            return($siblings);
        }

        foreach($this->_links[$key]['pred'] as $pred=>$item){
            if($item){
                foreach($this->_links[$pred]['succ'] as $succ=>$succItem){
                    if($succItem and $succ!=$key){
                        $siblings[]=$succ;
                    }
                }
            }
        }

        return($siblings);
    }

    public function node($key){
        $nodes=[];

        if(isset($this->_links[$key])){
            foreach($this->_links[$key]['pred'] as $pred=>$item){
                if($item) {
                    $nodes[] = $pred;
                }
            }
        }

        return($nodes);
    }

    public function item($key){
        $items=[];

        if(isset($this->_links[$key])){
            foreach($this->_links[$key]['succ'] as $succ=>$item){
                if($item) {
                    $items[] = $succ;
                }
            }
        }

        return($items);
    }

    public function load($path,$extend=false){
        $this->links=[];

        $f=fopen($path,'r');

        while(($line = fscanf($f,"%s\t%s\t%d\n"))){
            if(!isset($this->_links[$line[0]])){
                $this->_links[$line[0]]=['pred'=>[],'succ'=>[]];
            }

            if(!isset($this->_links[$line[1]])){
                $this->_links[$line[1]]=['pred'=>[],'succ'=>[]];
            }

            $this->_links[$line[0]]['succ'][$line[1]]=$line[2]==1;
            $this->_links[$line[1]]['pred'][$line[2]]=$line[2]==1;
        }

        fclose($f);

        if($extend){
            $this->extendAll();
        }
    }

    public function save($path,$shrink=false){
        if($shrink) {
            $this->shrinkAll();
        }

        $f=fopen($path,'w');

        foreach($this->_links as $pred=>$data){
            foreach($data['succ'] as $succ=>$item) {
                fwrite($f, "$pred\t$succ\t".($item?1:0)."\n");
            }
        }

        fclose($f);
    }

    public function debug(){
        debug($this->_links);
    }
}
