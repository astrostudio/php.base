<?php
namespace Base\Module;

use Base\Base;

class ModuleServerModuleFactory implements IModuleFactory {

    public function get(array $options=[]){
        return(new ModuleServerModule(
            new ModuleServer(Base::get($options,'modules',[])),
            Base::get($options,'name','module')
        ));
    }

}