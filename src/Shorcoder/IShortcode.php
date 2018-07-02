<?php
namespace Base\Shortcoder;

interface IShortcode {

    function process(array $params=[],$body=null);

}