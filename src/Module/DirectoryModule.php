<?php
namespace Base\Module;

use Base\Base;

class DirectoryModule implements IModule {

    private $__directory=[];

    public function __construct(array $directory=[]){
        $this->__directory=$directory;
    }

    public function execute($action=false,array $options=[]){
        $path=Base::get($options,'path',false);

        if(empty($path)){
            return($this->__directory);
        }

        return(Base::get($this->__directory,$path));
    }

}