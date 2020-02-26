<?php
namespace Base\Api;

interface ApiActionInterface
{
    function execute(array $query=[]);
}
