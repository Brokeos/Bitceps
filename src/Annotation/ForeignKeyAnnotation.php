<?php


namespace App\Annotation;


class ForeignKeyAnnotation extends AbstractAnnotation
{

    public function __construct($entity)
    {
        parent::__construct($entity);
    }

    public function getValue()
    {
        return $this->value;
    }
}