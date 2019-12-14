<?php


namespace App;


use App\Entity\User;

class Auth
{

    private $isAuth;
    private $user;

    private function __construct(bool $isAuth, ?User $user)
    {
        $this->isAuth = $isAuth;
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->isAuth;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public static function auth($email, $password): self
    {
        $userRepository = Kernel::getModel(User::class);
        $user = $userRepository->getByEmail($email);
        if ($user == null)
        {
            return new self(false, null);
        }
        if (!self::compareHashs($password, $user->getPassword()))
        {
            return new self(false, null);
        }
        return new self(true, $user);
    }

    public static function compareHashs($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function registerUser(User $user)
    {
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
        $user->setPassword($password);
        Kernel::getModel(User::class)->insert($user);
    }

    public static function updateUser(User $user)
    {
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
        $user->setPassword($password);
        Kernel::getModel(User::class)->update($user);
    }

}