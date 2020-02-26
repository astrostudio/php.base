<?php
namespace Base\Locale;

use Base\Locale\Server\ProxyLocaleServer;

class BasicLocale extends BaseLocale
{
    protected $_server;
    protected $_locale;

    public function __construct(LocaleServerInterface $server,string $locale=Locale::PL){
        $this->_server=new ProxyLocaleServer($server);
        $this->_locale=$locale;
    }

    public function getLocale():string
    {
        return($this->_locale);
    }

    public function setLocale(string $locale){
        $this->_locale=$locale;
    }

    public function get(string $alias):string
    {
        return($this->_server->translate($this->getLocale(),$alias));
    }

}
