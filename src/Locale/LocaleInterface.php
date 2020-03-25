<?php
namespace Base\Locale;

interface LocaleInterface
{
    function has(string $alias):bool;
    function get(string $alias):string;
}
