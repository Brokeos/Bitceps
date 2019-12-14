<?php


namespace App\Model;


use App\Entity\AbstractEntity;
use App\Kernel;
use PDO;

class Model
{

    protected $entity;
    protected $table;
    protected $primaryPropertyName;

    public function __construct($entity)
    {
        $this->entity = $entity;
        $this->table = AbstractEntity::getEntityTable($entity);
        $this->primaryPropertyName = AbstractEntity::getEntityPrimaryProperty($entity)->getName();
    }

    /**
     * @return AbstractEntity[]
     */
    public function getAll(): array
    {
        $query = Kernel::getDatabase()->query("SELECT * FROM `{$this->table}`;");
        return $query->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    /**
     * @param int $id
     * @return AbstractEntity|null
     * @throws \ReflectionException
     */
    public function getById(int $id): ?AbstractEntity
    {
        $query = Kernel::getDatabase()->query("SELECT * FROM `{$this->table}` WHERE `{$this->primaryPropertyName}`={$id};");
        return $query->fetchAll(PDO::FETCH_CLASS, $this->entity)[0] ?? null;
    }

    /**
     * @param AbstractEntity $abstractEntity
     * @return bool|\PDOStatement
     * @throws \ReflectionException
     */
    public function update(AbstractEntity $abstractEntity)
    {
        $primaryProperty = $abstractEntity->getPrimaryProperty();
        $properties = $abstractEntity->getProperties(true);
        $sql = "UPDATE `{$this->table}` SET ";
        foreach ($properties as $property)
        {
            $sql .= "`{$property->getName()}`=:{$property->getName()},";
        }
        $sql = substr($sql,0,-1);
        $sql .= " WHERE `{$primaryProperty->getName()}`=:{$primaryProperty->getName()};";
        $query = Kernel::getDatabase()->prepare($sql);
        $query->bindValue($primaryProperty->getName(), $primaryProperty->getValue());
        foreach ($properties as $property)
        {
            $query->bindValue($property->getName(), $property->getValue());
        }
        return $query->execute();
    }

    /**
     * @param AbstractEntity $abstractEntity
     * @return bool|\PDOStatement
     * @throws \ReflectionException
     */
    public function insert(AbstractEntity $abstractEntity)
    {
        $properties = $abstractEntity->getProperties(true);
        $sql = "INSERT INTO `{$this->table}` (";
        foreach ($properties as $property)
        {
            $sql .= "`{$property->getName()}`,";
        }
        $sql = substr($sql,0,-1);
        $sql.= ") VALUES (";
        foreach ($properties as $property)
        {
            $sql .= ":{$property->getName()},";
        }
        $sql = substr($sql,0,-1);
        $sql .= ");";
        $query = Kernel::getDatabase()->prepare($sql);
        foreach ($properties as $property)
        {
            $query->bindValue($property->getName(), $property->getValue());
        }
        return $query->execute();
    }

    /**
     * @param AbstractEntity $abstractEntity
     * @return bool
     * @throws \ReflectionException
     */
    public function delete(AbstractEntity $abstractEntity)
    {
        $primaryProperty = $abstractEntity->getPrimaryProperty();
        $query = Kernel::getDatabase()->query("DELETE FROM {$this->table} WHERE `{$primaryProperty->getName()}`={$primaryProperty->getValue()};");
        return $query->execute();
    }

}