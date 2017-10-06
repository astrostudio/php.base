<?php
namespace Base\Module;

use Exception;

class ModuleBuilderModule implements IModule {

    private $__builder=null;
    private $__options=null;

    public function __construct(IModuleBuilder $builder,array $options=[]){
        $this->__builder=$builder;
        $this->__options=array_merge([
            'name'=>'_name',
            'default'=>null,
            'options'=>'_options',
            'modules'=>null,
            'has'=>null
        ],$options);
    }

    public function execute($action=null,array $params=[]){
        if(!$this->__builder){
            throw new Exception('TranslAide\\Module\\ModuleBuilderModule::execute(): No builder');
        }

        if(!empty($this->__options['modules']) and $action==$this->__options['modules']){
            return($this->__builder->modules());
        }

        if(!empty($params[$this->__options['name']])){
            $name=$params[$this->__options['name']];
        }
        else if(!empty($this->__options['default'])){
            $name=$this->__options['default'];
        }

        if(empty($name)){
            throw new Exception('TranslAide\\Module\\ModuleBuilderModule::execute(): No module name');
        }

        if(!empty($this->__options['has']) and $action==$this->__options['has']){
            return($this->__builder->has($params[$this->__options['name']]));
        }

        $module=$this->__builder->get($name,isset($options[$this->__options['options']])?$options[$this->__options['options']]:[]);

        if(!$module){
            throw new Exception('TranslAide\\Module\\ModuleBuilderModule::execute(): Module "'.$name.'" does not exist"');
        }

        return($module->execute($action,$params));
    }
}