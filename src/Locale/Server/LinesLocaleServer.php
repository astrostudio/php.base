<?php
namespace Base\Locale\Server;

class LinesLocaleServer extends BasicLocaleServer
{
    public function __construct(array $paths=[]){
        parent::__construct([]);

        foreach($paths as $locale=>$path) {
            $this->set($locale, self::loadFromLines($path,'__{{ALIAS}}__'));
        }
    }

}
