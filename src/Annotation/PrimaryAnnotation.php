<?php


namespace App\Annotation;


class PrimaryAnnotation extends AbstractAnnotation
{

    public function __construct(?int $value)
    {
        parent::__construct($value);
    }

    public function getValue()
    {
        return $this->value;
    }

}