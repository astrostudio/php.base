<?php
namespace Base\Locale\Server;

class BasicLocaleServer extends BaseLocaleServer
{
    private $aliases=[];

    public function __construct(array $aliases=[]){
        $this->set($aliases);
    }

    public function get(string $locale,string $alias):?string
    {
        return($this->aliases[$locale][$alias]??null);
    }

    public function set($locale,$alias=null,$label=null){
        if(is_array($locale)){
            foreach($locale as $l=>$a){
                $this->set($l,$a);
            }

            return;
        }

        if(is_array($alias)){
            foreach($alias as $a=>$l){
                $this->set($locale,$a,$l);
            }

            return;
        }

        unset($this->aliases[$locale][$alias]);

        if(is_string($label)){
            if(!isset($this->aliases[$locale])){
                $this->aliases[$locale]=[];
            }

            $this->aliases[$locale][$alias]=$label;
        }
    }

    public function loadFromPhp(string $path){
        $this->set(include $path);
    }

    public function loadFromJson(string $path){
        $this->set(json_decode(file_get_contents($path),true));
    }

    const ALIAS='{{ALIAS}}';

    static public function loadFromLines(string $path,$empty=false){
        if(!file_exists($path)){
            return([]);
        }

        if($empty!==false){
            if(!is_string($empty)){
                $empty=self::ALIAS;
            }
        }

        $locales=[];
        $file=fopen($path,"rt");

        while(!feof($file)){
            $line=rtrim(fgets($file));

            if(!empty($line) and (mb_substr($line,0,1)!=='%')){
                $alias=$line;
                $value='';

                while(!feof($file) and !empty(($line=rtrim(fgets($file))))) {
                    if(mb_substr($line,0,1)!=='%') {
                        $value .= $line;
                    }
                }

                if(($empty!==false) or !empty($value)) {
                    $locales[$alias] = !empty($value)?$value:str_replace(self::ALIAS,$alias,$empty);
                }
            }
        }

        fclose($file);

        return($locales);
    }
}
