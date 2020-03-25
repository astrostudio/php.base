<?php
namespace Base\Locale;

class ProxyLocale extends BaseLocale
{
    protected $_locale;

    public function __construct(LocaleInterface $locale=null){
        $this->_locale=$locale;
    }

    public function has(string $alias):bool
    {
        return($this->_locale?$this->_locale->has($alias):false);
    }

    public function get(string $alias):string
    {
        return($this->_locale?$this->_locale->get($alias):$alias);
    }
}
