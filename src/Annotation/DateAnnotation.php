<?php


namespace App\Annotation;


class DateAnnotation extends AbstractAnnotation
{

    public function __construct($dateTime)
    {
        parent::__construct($dateTime);
    }

    public function getValue()
    {
        if ($this->value instanceof \DateTime)
        {
            return $this->value->format('Y-m-d');
        }
        else {
            return $this->value;
        }
    }

}