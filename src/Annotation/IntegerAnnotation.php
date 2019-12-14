<?php


namespace App\Annotation;


class IntegerAnnotation extends AbstractAnnotation
{

    public function __construct(?string $value)
    {
        parent::__construct($value);
    }

    public function getValue()
    {
        return (int)$this->value;
    }

}