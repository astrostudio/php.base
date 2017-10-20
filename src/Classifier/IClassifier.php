<?php
namespace Base\Classifier;

interface IClassifier {

    function is($subClasifier,$classifier);
    function get($classifier);
    function has($classifier=null);

}
