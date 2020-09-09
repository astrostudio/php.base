<?php
namespace Base\Frame;

interface FrameConverterInterface
{
    function convert($value):?FrameInterface;
}
