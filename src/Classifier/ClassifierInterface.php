<?php
namespace Base\Classifier;

interface ClassifierInterface {

    function is($subClasifier,$classifier);
    function get($classifier);
    function has($classifier=null);

}
