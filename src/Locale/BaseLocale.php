<?php
namespace Base\Locale;

abstract class BaseLocale implements  LocaleInterface
{
    public function translate(array $aliases=[],string $prefix=''):array
    {
        $translation=[];

        foreach($aliases as $alias){
            $translation[$alias]=$this->get($prefix.$alias);
        }

        return($translation);
    }

    public function translateProfile(array $profile=[]):array
    {
        $localeProfile=[];

        foreach($profile as $key=>$value){
            if(is_array($value)){
                $value=$this->translateProfile($value);
            }

            $localeProfile[$this->get($key)]=$value;
        }

        return($localeProfile);
    }

    public function translateList(array $list=[]):array
    {
        $translations=[];

        foreach($list as $alias){
            $translations[$alias]=$this->get($alias);
        }

        return($translations);
    }

    public function translateKey(array $list=[],bool $recursive=false):array
    {
        $translations=[];

        foreach($list as $key=>$value){
            if(is_array($value) and $recursive){
                $value=$this->translateKey($value);
            }

            $translations[$this->get($key)]=$value;
        }

        return($translations);
    }
}
