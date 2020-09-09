<?php
namespace Base\Relation;

class ExplodeRelation extends ProxyRelation
{
    const SEPARATOR='-';

    protected $_relations;

    /** @var string */
    protected $_separator;

    protected $_prefix;

    public function __construct(RelationInterface $relation,array $relations=[],string $separator=self::SEPARATOR,bool $prefix=false)
    {
        parent::__construct($relation);

        $this->_relations=$relations;
        $this->_separator=$separator;
        $this->_prefix=$prefix;
    }

    public function isA($subConcept,$concept):bool{
        if(!is_string($subConcept) or !is_string($concept)){
            return(false);
        }

        $subItems=explode($this->_separator,$subConcept);
        $subItemCount=count($subItems);
        $items=explode($this->_separator,$concept);
        $itemCount=count($items);

        if($this->_prefix){
            if($subItemCount<$itemCount){
                return(false);
            }
        }
        else  if($subItemCount!=$itemCount){
            return(false);
        }

        for($i=0;$i<$itemCount;++$i){
            if(isset($this->_relations[$i])){
                if(!$this->_relations[$i]->isA($subItems[$i],$items[$i])){
                    return(false);
                }
            }
            else {
                if (!parent::isA($subItems[$i], $items[$i])) {
                    return (false);
                }
            }
        }

        return(true);
    }

}
