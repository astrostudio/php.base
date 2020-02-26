<?php
namespace Base\Locale;

interface LocaleInterface
{
    function get(string $alias):string;

}
