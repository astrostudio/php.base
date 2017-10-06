<?php
namespace Base\Module;

class ServiceModuleFactory implements IModuleFactory {

    public function get(array $options=[]){
        $url=!empty($options['url'])?$options['url']:'';
        $moduleOptions=!empty($options['options'])?$options['options']:[];
        $curlOptions=!empty($options['curlOptions'])?$options['curlOptions']:[];

        return(new ServiceModule($url,$moduleOptions,$curlOptions));
    }

}