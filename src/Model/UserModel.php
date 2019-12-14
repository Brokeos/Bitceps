<?php


namespace App\Model;


use App\Entity\User;
use App\Kernel;
use PDO;

class UserModel extends Model
{

    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        $query = Kernel::getDatabase()->prepare("SELECT * FROM {$this->table} WHERE `email`=:email;");
        $query->bindValue('email', $email);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, User::class)[0] ?? null;
    }

}