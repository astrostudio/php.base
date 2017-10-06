<?php
namespace Base\Module;

interface IModuleServer {

    function modules();
    function has($name);
    function execute($name,$action=null,array $params=[]);

}