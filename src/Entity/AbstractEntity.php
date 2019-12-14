<?php

namespace App\Entity;

use App\Annotation\ForeignKeyAnnotation;
use App\Annotation\PrimaryAnnotation;
use App\Annotation\Property;
use App\Helper;
use ReflectionClass;

abstract class AbstractEntity
{

    /**
     * @return string
     * @throws \ReflectionException
     */
    public function getTable(): string
    {
        $table = '';
        $rc = new ReflectionClass(get_called_class());
        $doc = $rc->getDocComment();
        $doc = explode("\n", $doc);
        foreach ($doc as $value)
        {
            if (strpos($value, "@"))
            {
                $annotation = trim(explode("@", $value)[1]);
                $tags = explode(' ', $annotation);
                if ($tags[0] == 'Table')
                {
                    $table = $tags[1];
                }
            }
        }
        return $table;
    }

    /**
     * @param bool $excludePrimary
     * @return Property[]
     * @throws \ReflectionException
     */
    public function getProperties(bool $excludePrimary = false): array
    {
        $properties = [];
        $rc = new ReflectionClass(get_called_class());
        foreach ($rc->getProperties() as $property)
        {
            $doc = $property->getDocComment();
            if ($doc != false)
            {
                $propertyAnnoted = Property::parseProperty($this, $property->getName(), $property->getDocComment());
                if (!$propertyAnnoted->isPrimary() || !$excludePrimary)
                {
                    array_push($properties, $propertyAnnoted);
                }
            }
        }
        return $properties;
    }

    /**
     * @return Property|null
     * @throws \ReflectionException
     */
    public function getPrimaryProperty(): ?Property
    {
        $properties = $this->getProperties();
        foreach ($properties as $property)
        {
            if ($property->isPrimary())
            {
                return $property;
            }
        }
        return null;
    }

    /**
     * @return Property[]
     * @throws \ReflectionException
     */
    public function getForeignProperties(): array
    {
        $foreignProperties = [];
        $properties = $this->getProperties();
        foreach($properties as $property)
        {
            if ($property->isForeygnKey())
            {
                array_push($foreignProperties, $property);
            }
        }
        return $foreignProperties;
    }

    /**
     * @param string $entity
     * @return Property|null
     * @throws \ReflectionException
     */
    public function getForeignProperty(string $class): ?Property
    {
        $foreignProperties = $this->getForeignProperties();
        foreach($foreignProperties as $foreignProperty)
        {
            foreach($foreignProperty->getAnnotations() as $annotation)
            {
                if ($annotation instanceof ForeignKeyAnnotation)
                {
                    if ($annotation->getValue() == $class)
                    {
                        return $foreignProperty;
                    }
                }
            }
        }
        return null;
    }

    /**
     * @param $entity
     * @return string
     */
    public static function getEntityTable($entity): string
    {
        return (new $entity)->getTable();
    }

    /**
     * @param $entity
     * @param bool $excludePrimary
     * @return Property[]
     * @throws \ReflectionException
     */
    public static function getEntityProperties($entity, bool $excludePrimary = false): array
    {
        $properties = [];
        $rc = new ReflectionClass($entity);
        foreach ($rc->getProperties() as $property)
        {
            $doc = $property->getDocComment();
            if ($doc != false)
            {
                $propertyAnnoted = Property::parseProperty(null, $property->getName(), $property->getDocComment(), false);
                if (!$propertyAnnoted->isPrimary() || !$excludePrimary)
                {
                    array_push($properties, $propertyAnnoted);
                }
            }
        }
        return $properties;
    }

    /**
     * @param $entity
     * @return Property|null
     * @throws \ReflectionException
     */
    public static function getEntityPrimaryProperty($entity): ?Property
    {
        $properties = self::getEntityProperties($entity);
        foreach ($properties as $property)
        {
            if ($property->isPrimary())
            {
                return $property;
            }
        }
        return null;
    }

    /**
     * @param $entity
     * @return Property[]
     * @throws \ReflectionException
     */
    public static function getEntityForeignProperties($entity): array
    {
        $foreignProperties = [];
        $properties = self::getEntityProperties($entity);
        foreach($properties as $property)
        {
            if ($property->isForeygnKey())
            {
                array_push($foreignProperties, $property);
            }
        }
        return $foreignProperties;
    }

    /**
     * @param $entity
     * @param string $class
     * @return Property|null
     * @throws \ReflectionException
     */
    public static function getEntityForeignProperty($entity, string $class): ?Property
    {
        $foreignProperties = self::getEntityForeignProperties($entity);
        foreach($foreignProperties as $foreignProperty)
        {
            foreach($foreignProperty->getAnnotations() as $annotation)
            {
                if ($annotation instanceof ForeignKeyAnnotation)
                {
                    if ($annotation->getValue() == $class)
                    {
                        return $foreignProperty;
                    }
                }
            }
        }
        return null;
    }

}