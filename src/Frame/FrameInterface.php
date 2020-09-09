<?php
namespace Base\Frame;

use JsonSerializable;

interface FrameInterface extends JsonSerializable
{
    function keys():array;
    function has($key):bool;
    function get($key);
}
