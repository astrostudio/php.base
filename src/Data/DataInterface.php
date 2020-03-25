<?php
namespace Base\Data;

interface DataInterface
{
    function exists():bool;
    function load();
    function save($data=null);
    function delete();
}
