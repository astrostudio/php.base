<?php
namespace Base\Executor;

interface ExecutorInterface
{
    function execute(string $cmd);
    function launch(string $cmd):?int;
    function kill(int $pid);
}
