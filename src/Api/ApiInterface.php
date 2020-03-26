<?php
namespace Base\Api;

interface ApiInterface
{
    function actions():array;
    function has(string $action):bool;
    function execute(string $action,array $query=[]);
}
