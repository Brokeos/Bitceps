<?php


namespace App\Validator;


use DateTime;

class DateValidator extends AbstractValidator
{

    private $field;
    private $type;
    private $checkDate;

    public function __construct($value, string $field, string $type, bool $checkDate)
    {
        $this->field = $field;
        $this->type = $type;
        $this->checkDate = $checkDate;
        parent::__construct($value);
    }

    public function validate(): bool
    {
        $date = DateTime::createFromFormat('Y-m-d', $this->value);
        if ($this->checkDate && $date != false)
        {
            $now = (new \DateTime('now'))->format('U');
            $input = $date->format('U');
            return $now >= $input;
        }
        return $date !== false;
    }

    public function getError(): string
    {
        switch($this->type)
        {
            case 'f':
                return "La {$this->field} n'a pas une valeur correcte";
            case 'o':
                return "L'{$this->field} n'a pas une valeur correcte";
        }
        return "Le {$this->field} n'a pas une valeur correcte";
    }
}