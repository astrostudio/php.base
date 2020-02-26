<?php
namespace Base\Locale\Server;

use Base\Locale\LocaleServerInterface;

abstract class BaseLocaleServer implements LocaleServerInterface
{
    public function translate(string $locale,string $alias):string
    {
        if(($label=$this->get($locale,$alias))===null){
            return($alias);
        }

        return($label);
    }

    public function translateProfile(string $locale,array $profile=[]):array
    {
        $localeProfile=[];

        foreach($profile as $key=>$value){
            if(is_array($value)){
                $value=$this->translateProfile($locale,$value);
            }

            $localeProfile[$this->translate($locale,$key)]=$value;
        }

        return($localeProfile);
    }
}
