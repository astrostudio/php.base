<?php
namespace Base;

class Data
{
    static public function saveAsJson(string $path,array $data=[]):bool
    {
        return(file_put_contents($path,json_encode($data)));
    }

    static public function loadAsJson(string $path):array
    {
        return(json_decode(file_get_contents($path),true));
    }

    static public function saveAsClass(string $path,string $class,$name,$data=null){
        if(file_put_contents($path,'<?php'."\n")===false){
            return(false);
        }

        $classAt=mb_strrpos($class,'\\');

        if($classAt!==false){
            file_put_contents($path,'namespace '.mb_substr($class,0,$classAt).';'."\n",FILE_APPEND);

            $class=mb_substr($class,$classAt+1);
        }

        file_put_contents($path,"\n",FILE_APPEND);
        file_put_contents($path,'class '.$class."\n".'{'."\n\n",FILE_APPEND);

        if(!is_array($name)){
            $name=[$name=>$data];
        }

        if(!empty($name)){
            foreach($name as $n=>$d){
                file_put_contents($path,'    static public $'.$n.'='.var_export($d,true).';'."\n\n",FILE_APPEND);
            }
        }

        file_put_contents($path,'}'."\n",FILE_APPEND);

        return(true);
    }

    static public function saveAsInclude(string $path,$data=null){
        return(file_put_contents($path,'<?php'."\n".'return('.var_export($data,true).');'."\n",FILE_APPEND));
    }

    static public function loadAsInclude(string $path){
        return(include $path);
    }

}
