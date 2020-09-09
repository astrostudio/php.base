<?php
namespace Base\Log;

interface LogInterface
{
    function write(string $message);
}
