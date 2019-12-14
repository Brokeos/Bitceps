<?php


namespace App\Annotation;


class StringAnnotation extends AbstractAnnotation
{

    public function __construct(?string $value)
    {
        parent::__construct($value);
    }

    public function getValue()
    {
        return $this->value;
    }

}