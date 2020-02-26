<?php
namespace Base\Locale\Server;

use Base\Locale\LocaleServerInterface;

class ProxyLocaleServer extends BaseLocaleServer
{
    protected $_server;

    public function __construct(LocaleServerInterface $server=null){
        $this->_server=$server;
    }

    public function get(string $locale,string $alias):?string
    {
        return($this->_server?$this->_server->get($locale,$alias):null);
    }
}
