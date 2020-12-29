<?php
namespace Base\Logger;

interface LoggerInterface
{
    function write(string $message,array $options=[]);
}
