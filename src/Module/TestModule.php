<?php
namespace Base\Module;

class TestModule implements IModule {

    public function execute($action=null,array $params=[]){
        return([!empty($action)?$action:''=>$params]);
    }

}