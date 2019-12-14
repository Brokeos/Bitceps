<?php


namespace App\Controller;


use App\Auth;
use App\Entity\User;
use App\Kernel;
use App\Router\Route;
use App\Templater;
use App\Validator\DateValidator;
use App\Validator\EmailValidator;
use App\Validator\InArrayValidator;
use App\Validator\LengthValidator;
use App\Validator\PasswordValidator;
use App\Validator\UniqueEntityValueValidator;
use App\Validator\Validator;
use DateTime;

class SecurityController extends AbstractController
{

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return [
            new Route('security.login', "/login", ['GET'], function() { self::login(); }),
            new Route('security.login.post', "/login", ['POST'], function() { self::postLogin(); }),
            new Route('security.register', "/register", ['GET'], function() { self::register(); }),
            new Route('security.register.post', "/register", ['POST'], function() { self::postRegister(); }),
            new Route('security.logout',"/logout", ['GET'], function() { self::logout(); })
        ];
    }

    public function login(): void
    {
        Templater::render('security/login.html.php', ['active' => 'login', 'title' => 'Connexion']);
    }

    public function postLogin(): void
    {
        $email = Kernel::post('email');
        $password = Kernel::post('password');
        $auth = Auth::auth($email, $password);
        if ($auth->isAuth())
        {
            $_SESSION['authed'] = true;
            $_SESSION['userid'] = $auth->getUser()->getId();
            Templater::redirect("");
        } else
        {
            Templater::render('security/login.html.php', ['active' => 'login', 'title' => 'Connexion', 'error' => true]);
        }
    }

    public function register(): void
    {
        Templater::render('security/register.html.php', ['active' => 'login', 'title' => 'Inscription']);
    }

    public function postRegister(): void
    {
        $emailValidator = new EmailValidator(Kernel::post('email'));
        $uniqueEmailValidator = new UniqueEntityValueValidator(Kernel::post('email'), 'adresse email', User::class, 'email', 'of', false);
        $passwordValidator = new PasswordValidator(Kernel::post('password'), Kernel::post('confirmpassword'));
        $passwordLengthValidator = new LengthValidator(Kernel::post('password'),"mot de passe", 'm', 6, 32);
        $firstnameValidator = new LengthValidator(Kernel::post('firstname'), 'prénom', 'm', 4, 20);
        $lastnameValidator = new LengthValidator(Kernel::post('lastname'), 'nom', 'm', 4, 20);
        $genderValidator = new InArrayValidator(Kernel::post('gender'), 'genre', 'm', ['male', 'female']);
        $dateValidator = new DateValidator(Kernel::post('birthdate'), "date d'anniversaire", 'f');
        $constraints = Validator::constraintsValidator([$emailValidator, $uniqueEmailValidator, $passwordValidator, $passwordLengthValidator, $firstnameValidator, $lastnameValidator, $genderValidator, $dateValidator]);
        if ($constraints->getPassed())
        {
            $user = new User();
            $user->setEmail(Kernel::post('email'));
            $user->setPassword(Kernel::post('password'));
            $user->setFirstname(Kernel::post('firstname'));
            $user->setlastname(Kernel::post('lastname'));
            $user->setGender(Kernel::post('gender'));
            $user->setBirthdate(new DateTime(Kernel::post('birthdate')));
            Auth::registerUser($user);
            Templater::render('security/register.html.php', ['active' => 'login', 'title' => 'Inscription', 'success' => true]);
        } else
        {
            Templater::render('security/register.html.php', ['active' => 'login', 'title' => 'Inscription', 'errors' => $constraints->getErrors()]);
        }
    }

    public function logout(): void
    {
        session_destroy();
        Templater::redirect('');
    }

}