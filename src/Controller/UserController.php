<?php


namespace App\Controller;


use App\Auth;
use App\Entity\Participation;
use App\Entity\Tarif;
use App\Entity\User;
use App\Kernel;
use App\Router\Route;
use App\Templater;
use App\Validator\LengthValidator;
use App\Validator\PasswordValidator;
use App\Validator\Validator;

class UserController extends AbstractController
{

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        if (Kernel::isAuthed()){
            return [
                new Route('user.participation.add', '/participation/add/{id}', ['GET'], function ($id) { self::addParticipation($id); }),
                new Route('user.participation.del', '/participation/del/{id}', ['GET'], function ($id) { self::removeParticipation($id); }),
                new Route('user.profile','/profile', ['GET'], function () { self::profile(); }),
                new Route('user.changepassword', '/profile', ['POST'], function () { self::changePassword(); }),
                new Route('user.checkout','/checkout/{id}', ['GET'], function($id) { self::checkout($id); }),
                new Route('user.checkout.post','/checkout/{id}', ['POST'], function($id) { self::checkoutPost($id); }),
                new Route('user.cancelsub','/cancelsub', ['GET'], function () { self::cancelSub(); })
            ];
        } else
        {
            return [];
        }
    }


    public function addParticipation($id): void
    {
        $userParticipations = Kernel::getModel(Participation::class)->getByUser(Kernel::getUser());
        $participations = [];
        foreach ($userParticipations as $participation)
        {
            array_push($participations, $participation->getLessonId());
        }
        if (!in_array($id, $participations))
        {
            $participation = new Participation();
            $participation->setUser(Kernel::getUser());
            $participation->setLessonId($id);
            Kernel::getModel(Participation::class)->insert($participation);
            Templater::redirect('planning');
        }
        Templater::redirect('planning');
    }

    public function removeParticipation($id): void
    {
        $participation = new Participation();
        $participation->setUser(Kernel::getUser());
        $participation->setLessonId($id);
        Kernel::getModel(Participation::class)->delete($participation);
        Templater::redirect('planning');
    }

    public function profile(): void
    {
        Templater::render('profile/index.html.php', ['active' => 'profile', 'title' => 'Mon profil']);
    }

    public function checkout($id): void
    {
        $tarif = Kernel::getModel(Tarif::class)->getById($id);
        Templater::render('home/checkout.html.php', ['active' => 'tarifs', 'title' => 'Paiement', 'tarif' => $tarif]);
    }

    public function checkoutPost($id): void
    {
        $tarif = Kernel::getModel(Tarif::class)->getById($id);
        $user = Kernel::getUser();
        $user->setSubscription($tarif);
        Kernel::getModel(User::class)->update($user);
        Templater::redirect('profile', 3);
        Templater::render('home/checkout.html.php', ['active' => 'tarifs', 'title' => 'Paiement', 'success' => true]);
    }

    public function cancelSub(): void
    {
        $user = Kernel::getUser();
        $user->setSubscriptionID(null);
        Kernel::getModel(User::class)->update($user);
        Templater::redirect('profile');
    }

    public function changePassword(): void
    {
        $actualPassowrdValidation = Auth::compareHashs(Kernel::post('password'), Kernel::getUser()->getPassword());
        if ($actualPassowrdValidation)
        {
            $passwordValidator = new PasswordValidator(Kernel::post('newpassword'), Kernel::post('confirmnewpassword'));
            $passwordLengthValidator = new LengthValidator(Kernel::post('newpassword'),"nouveau mot de passe", 'm', 6, 32);
            $constraints = Validator::constraintsValidator([$passwordValidator, $passwordLengthValidator]);
            if ($constraints->getPassed())
            {
                $user = Kernel::getUser();
                $user->setPassword(Kernel::post('newpassword'));
                Auth::updateUser($user);
                Templater::render('profile/index.html.php', ['active' => 'profile', 'title' => 'Mon profil', 'success' => true]);
            } else
            {
                Templater::render('profile/index.html.php', ['active' => 'profile', 'title' => 'Mon profil', 'errors' => $constraints->getErrors()]);
            }
        } else
        {
            Templater::render('profile/index.html.php', ['active' => 'profile', 'title' => 'Mon profil', 'errors' => ['Le mot de passe est incorrect']]);
        }
    }

}