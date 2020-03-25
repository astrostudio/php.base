<?php
namespace Base\Repository;

interface RepositoryInterface
{
    function allows(string $id):bool;
    function has(string $id):bool;
    function get(string $id,array $options=[]);
    function set(string $id,$data=null,array $options=[]);
    function delete(string $id,array $options=[]);
}
