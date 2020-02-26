<?php
namespace Base\Locale\Server;

class DomainLocaleServer extends LayerLocaleServer
{
    const DELIMITER='.';

    private $delimiter;

    public function __construct(array $servers=[],string $delimiter=self::DELIMITER){
        parent::__construct($servers);

        $this->delimiter=$delimiter;
    }

    public function get(string $locale,string $alias):?string
    {
        if(($i=mb_strpos($alias,$this->delimiter))===false){
            return(null);
        }

        $domain=mb_substr($alias,0,$i);
        $alias=mb_substr($alias,$i+1);

        if(!isset($this->_servers[$domain])){
            return(null);
        }

        return($this->_servers[$domain]->get($locale,$alias));
    }

}
