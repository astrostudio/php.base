<?php
namespace Base\Module;

interface IModuleBuilder {

    function modules();
    function has($name);
    function get($name,array $options=[]);

}