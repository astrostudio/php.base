<?php
namespace Base\Locale;

interface LocaleServerInterface
{
    function get(string $locale,string $alias):?string;
}
