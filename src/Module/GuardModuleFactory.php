<?php
namespace Base\Module;

class GuardModuleFactory extends ProxyModuleFactory {

    public function __construct(IModuleFactory $factory=null){
        parent::__construct($factory);
    }

    public function get(array $options=[]){
        $moduleOptions=!empty($options['options'])?$options['options']:[];
        $settings=!empty($options['settings'])?$options['settings']:[];

        return(new GuardModule(parent::get($moduleOptions),$settings));
    }
}