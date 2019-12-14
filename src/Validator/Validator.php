<?php


namespace App\Validator;


class Validator
{

    private $errors;
    private $passed;

    public function __construct($errors, $passed)
    {
        $this->errors = $errors;
        $this->passed = $passed;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function getPassed()
    {
        return $this->passed;
    }

    /**
     * @param AbstractValidator[] $validators
     * @return Validator
     */
    public static function constraintsValidator(array $validators): self
    {
        $passed = true;
        $errors = [];
        foreach ($validators as $validator){
            if (!$validator->validate()){
                $passed = false;
                array_push($errors, $validator->getError());
            }
        }
        return new self($errors, $passed);
    }

}