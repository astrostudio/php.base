<?php
namespace Base\Module;

interface IModule {

    function execute($action=null,array $params=[]);

}