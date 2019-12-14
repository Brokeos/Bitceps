<?php


namespace App\Validator;


use App\Entity\AbstractEntity;
use App\Helper;
use App\Kernel;

class UniqueEntityValueValidator extends AbstractValidator
{

    private $field;
    private $entity;
    private $property;
    private $type;
    private $caseSensitive;

    public function __construct($value, string $field, $entity, string $property, string $type, bool $caseSensitive)
    {
        $this->field = $field;
        $this->entity = $entity;
        $this->property = $property;
        $this->type = $type;
        $this->caseSensitive = $caseSensitive;
        parent::__construct($this->caseSensitive ? $value : strtolower($value));
    }

    public function validate(): bool
    {
        $repository = Kernel::getModel($this->entity);
        $data = $repository->getAll();
        foreach($data as $datum)
        {
            $datuv = Helper::forceGet($datum, $this->property);
            if (!empty($datuv))
            {
                $datuv = $this->caseSensitive ? $datuv : strtolower($datuv);
                if ($datuv == $this->value)
                {
                    return false;
                }
            } else
            {
                throw new \Exception("La propriété " . $this->property . " n'existe pas pour la classe " . $this->entity);
            }
        }
        return true;
    }

    public function getError(): string
    {
        switch($this->type)
        {
            case 'f':
                return "La {$this->field} est déjà utilisée";
            case 'o':
                return "L'{$this->field} est déjà utilisé";
            case 'of':
                return "L'{$this->field} est déjà utilisée";
        }
        return "Le {$this->field} est déjà utilisé";
    }
}