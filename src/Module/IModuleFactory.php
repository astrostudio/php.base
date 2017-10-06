<?php
namespace Base\Module;

interface IModuleFactory {

    function get(array $options=[]);

}