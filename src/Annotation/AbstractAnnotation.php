<?php

namespace App\Annotation;

abstract class AbstractAnnotation
{

    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;
    }

    public abstract function getValue();

}