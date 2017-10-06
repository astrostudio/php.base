<?php
namespace Base\Classifier;

interface IClassifier {

    function is($subClassifier,$classifier=null);
    function get($classifier=null);

}
