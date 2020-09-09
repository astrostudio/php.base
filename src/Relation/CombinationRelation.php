<?php
namespace Base\Relation;

class CombinationRelation extends ProxyRelation
{
    static public function convert(array $map=[]):array
    {
        $set=[];

        foreach($map as $item){
            $set[]=$item;
        }

        return($set);
    }

    private function candidates(array $subSet=[],array $set=[]){
        $candidates=[];

        foreach($set as $key=>$item){
            $candidates[$key]=[];

            foreach($subSet as $subKey=>$subItem){
                if(parent::isA($subItem,$item)){
                    $candidates[$key][]=$subKey;
                }
            }

            if(empty($candidates[$key])){
                return(false);
            }
        }

        return($candidates);
    }

    private function __mapping(array $candidates,$i,$c,array $map,array &$maps,bool $first,bool $multi){
        if($i>=$c){
            $maps[]=$map;

            if($first){
                return(true);
            }

            return(false);
        }

        $cc=count($candidates[$i]);

        for($j=0;$j<$cc;++$j){
            if($multi or !in_array($candidates[$i][$j],$map)){
                $subMap=$map;
                $subMap[$i]=$candidates[$i][$j];

                if($this->__mapping($candidates,$i+1,$c,$subMap,$maps,$first,$multi)){
                    return(true);
                }
            }
        }

        return(false);
    }

    public function mapping(array $subSet=[],array $set=[],bool $first=true,bool $multi=false)
    {
        $subSet=self::convert($subSet);
        $set=self::convert($set);

        if(($candidates=$this->candidates($subSet,$set))===false){
            return(false);
        };

        $c=count($candidates);

        $maps=[];

        if($this->__mapping($candidates,0,$c,[],$maps,$first,$multi)){
            return($maps);
        }

        return($maps);
    }

    public function __construct(RelationInterface $relation=null){
        parent::__construct($relation);
    }


    public function isA($subConcept,$concept):bool
    {
        if(!is_array($subConcept) or !is_array($concept)){
            return(false);
        }

        $maps=$this->mapping($subConcept,$concept,true,false);

        return(!empty($maps));
    }
}
