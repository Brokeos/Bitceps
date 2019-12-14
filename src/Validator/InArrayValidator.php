<?php


namespace App\Validator;


class InArrayValidator extends AbstractValidator
{

    private $field;
    private $type;
    private $array;

    public function __construct($value, string $field, string $type, array $array)
    {
        $this->field = $field;
        $this->type = $type;
        $this->array = $array;
        parent::__construct($value);
    }

    public function validate(): bool
    {
        return in_array($this->value, $this->array);
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