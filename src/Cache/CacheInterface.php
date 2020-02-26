<?php
namespace Base\Cache;

interface CacheInterface
{
    function has(string $key):bool;
    function get(string $key);
    function set(string $key,$value);
    function remove(string $key);
}
