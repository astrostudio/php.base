<?php
namespace Base\Module;

class DirectoryModuleFactory implements IModuleFactory {

    public function get(array $options=[]){
        return(new DirectoryModule($options));
    }

}