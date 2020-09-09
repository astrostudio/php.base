<?php
namespace Base\Relation;

class SlotRelation extends LayerRelation {

    public function __construct(){
        parent::__construct([new EachRelation(),new EqualRelation()]);
    }

}
