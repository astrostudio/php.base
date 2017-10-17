<?php
namespace Base;

interface IFactory {
    
    function get(array $options=[]);
    
}