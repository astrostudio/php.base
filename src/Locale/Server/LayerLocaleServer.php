<?php
namespace Base\Locale\Server;

use Base\Locale\LocaleServerInterface;
use Base\Base;

class LayerLocaleServer extends BaseLocaleServer
{
    /** @var LocaleServerInterface[] */
    protected $_servers=[];

    public function __construct(array $servers=[]){
        $this->setServer($servers);
    }

    public function get(string $locale,string $alias):?string
    {
        foreach($this->_servers as $server){
            if(($label=$server->get($locale,$alias))!==null){
                return($label);
            }
        }

        return(null);
    }

    public function setServer($name,LocaleServerInterface $server=null,int $offset=null){
        if(is_array($name)){
            foreach($name as $n=>$s){
                $this->setServer($n,$s);
            }

            return;
        }

        unset($this->_servers[$name]);

        if($server){
            $this->_servers=Base::insert($this->_servers,$name,$server,$offset);
        }
    }
}
