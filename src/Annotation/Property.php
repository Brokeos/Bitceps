<?php


namespace App\Annotation;

use App\Helper;

class Property
{

    private $name;
    private $annotations;
    private $value;
    private $isPrimary = false;
    private $isForeygnKey = false;

    public function __construct(string $name, array $annotations = [])
    {
        $this->name = $name;
        $this->annotations = $annotations;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return AbstractAnnotation[]
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * @param AbstractAnnotation $annotation
     */
    public function addAnnotation(AbstractAnnotation $annotation): void
    {
        array_push($this->annotations, $annotation);
    }

    /**
     * @param $object
     * @param string $name
     * @param string $doc
     * @param bool $getValue
     * @return Property
     * @throws \Exception
     */
    public static function parseProperty($object, string $name, string $doc, bool $getValue = true): Property
    {
        $property = new self($name);
        $doc = explode("\n", $doc);
        foreach ($doc as $value)
        {
            if (strpos($value, "@"))
            {
                $annotation = explode(' ',trim(explode("@", $value)[1]));
                $value = null;
                if ($getValue)
                {
                    $value = Helper::forceGet($object, $name);
                }
                switch($annotation[0])
                {
                    case 'String':
                        $stringAnnotation = new StringAnnotation($value);
                        $property->value = $stringAnnotation->getValue();
                        $property->addAnnotation($stringAnnotation);
                        break;
                    case 'Integer':
                        $integerAnnotation = new IntegerAnnotation($value);
                        $property->value = $integerAnnotation->getValue();
                        $property->addAnnotation($integerAnnotation);
                        break;
                    case 'Date':
                        $dateAnnotation = new DateAnnotation($value);
                        $property->value = $dateAnnotation->getValue();
                        $property->addAnnotation($dateAnnotation);
                        break;
                    case 'Database_Field':
                        $property->addAnnotation(new DatabaseFieldAnnotation($value));
                        break;
                    case 'Primary':
                        $property->isPrimary = true;
                        $property->addAnnotation(new PrimaryAnnotation($value));
                        break;
                    case 'Foreign_Key':
                        $property->isForeygnKey = true;
                        $entityName = $annotation[1];
                        $property->addAnnotation(new ForeignKeyAnnotation($entityName));
                        break;
                }
            }
        }
        return $property;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->isPrimary;
    }

    /**
     * @return bool
     */
    public function isForeygnKey(): bool
    {
        return $this->isForeygnKey;
    }

}