<?php


namespace App\Controller;


use App\Entity\Lesson;
use App\Entity\Tarif;
use App\Entity\Trainer;
use App\Entity\User;
use App\Helper;
use App\Kernel;
use App\Router\Route;
use App\Templater;
use App\Validator\InArrayValidator;
use App\Validator\LengthValidator;
use App\Validator\LessonHoursValidator;
use App\Validator\Validator;

class AdminController extends AbstractController
{

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        if (Kernel::isAuthed() && Kernel::getUser()->getIsAdmin()){
            return [
                new Route('admin.home', '/admin', ['GET'], function() { self::trainers(); }),
                new Route('admin.trainers', '/admin/trainers', ['GET'], function() { self::trainers(); }),
                new Route('admin.trainers.edit','/admin/trainers/edit/{id}', ['GET'], function($id) { self::editTrainer($id); }),
                new Route('admin.trainers.edit.post','/admin/trainers/edit/{id}', ['POST'], function($id) { self::postEditTrainer($id); }),
                new Route('admin.planning','/admin/planning', ['GET'], function() { self::planning(); }),
                new Route('admin.planning.add','/admin/planning/add', ['GET'], function() { self::addLesson(); }),
                new Route('admin.planning.add.post','/admin/planning/add', ['POST'], function() { self::postAddLesson(); }),
                new Route('admin.planning.edit','/admin/planning/edit/{id}', ['GET'], function($id) { self::editLesson($id); }),
                new Route('admin.planning.edit.post','/admin/planning/edit/{id}', ['POST'], function($id) { self::postEditLesson($id); }),
                new Route('admin.planning.del','/admin/planning/del/{id}', ['GET'], function($id) { self::delLesson($id); }),
                new Route('admin.planning.trainer','/admin/planning/{id}', ['GET'], function($id) { self::trainerPlanning($id); }),
                new Route('admin.tarifs','/admin/tarifs', ['GET'], function() { self::tarifs(); }),
                new Route('admin.tarifs.edit','/admin/tarifs/edit/{id}', ['GET'], function($id) { self::editTarif($id); }),
                new Route('admin.tarifs.edit.post','/admin/tarifs/edit/{id}', ['POST'], function($id) { self::postEditTarif($id); }),
                new Route('admin.users',"/admin/users", ['GET'], function() { self::users(); }),
                new Route('admin.participations',"/admin/participations", ['GET'], function() { self::participations(); }),
                new Route('admin.participations.lesson',"/admin/participations/{id}", ['GET'], function($id) { self::participationsLesson($id); })
            ];
        } else
        {
            return [];
        }
    }

    public function trainers(): void
    {
        $trainers = Kernel::getModel(Trainer::class)->getAll();
        Templater::render('admin/trainers/index.html.php', ['active' => 'admin', 'title' => 'Administration', 'trainers' => $trainers]);
    }

    public function editTrainer($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $trainer = Kernel::getModel(Trainer::class)->getById($id);
        Templater::render('admin/trainers/edit.html.php', ['active' => 'admin', 'title' => 'Editer un Entraineur', 'trainer' => $trainer]);
    }

    public function postEditTrainer($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $trainer = Kernel::getModel(Trainer::class)->getById($id);
        $nameValidator = new LengthValidator(Kernel::post('name'), 'nom', 'm', 3, 30);
        $categoryValidator = new LengthValidator(Kernel::post('category'), 'catégorie', 'f', 3, 30);
        $constraints = Validator::constraintsValidator([$nameValidator, $categoryValidator]);
        if ($constraints->getPassed())
        {
            if ($_FILES['picture']['size'] != 0)
            {
                $lastfile = ROOT . '/assets/img/trainers/' . $trainer->getPicture();
                if (file_exists($lastfile))
                {
                    unlink($lastfile);
                }
                move_uploaded_file($_FILES['picture']['tmp_name'], ROOT . '/assets/img/trainers/' . $_FILES['picture']['name']);
                $trainer->setPicture($_FILES['picture']['name']);
            }
            $trainer->setName(Kernel::post('name'));
            $trainer->setCategory(Kernel::post('category'));
            $trainer->setColor(Kernel::post('color'));
            Kernel::getModel(Trainer::class)->update($trainer);
            Templater::redirect("admin/trainers");
        } else
        {
            Templater::render('admin/trainers/edit.html.php', ['active' => 'admin', 'title' => 'Editer un Entraineur', 'trainer' => $trainer, 'errors' => $constraints->getErrors()]);
        }
    }

    public function planning(): void
    {
        $days = Helper::$days;
        $lessons = Kernel::getModel(Lesson::class)->getAll();
        $groupedLessons = Helper::groupLessonsByDays($lessons);
        Templater::render('admin/planning/index.html.php', ['active' => 'admin', 'title' => 'Administration', 'days' => $days, 'groupedLessons' => $groupedLessons]);
    }

    public function trainerPlanning($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $trainer = Kernel::getModel(Trainer::class)->getById($id);
        if ($trainer == null)
        {
            Templater::redirect("404");
        } else
        {
            $days = Helper::$days;
            $groupedLessons = Helper::groupLessonsByDays($trainer->getLessons());
            Templater::render('admin/planning/index.html.php', ['active' => 'admin', 'title' => 'Administration', 'days' => $days, 'groupedLessons' => $groupedLessons, 'trainer' => $trainer]);
        }
    }

    public function addLesson(): void
    {
        $trainers = Kernel::getModel(Trainer::class)->getAll();
        $days = Helper::$days;
        Templater::render('admin/planning/add.html.php', ['active' => 'admin', 'title' => 'Administration', 'trainers' => $trainers, 'days' => $days]);
    }

    public function postAddLesson(): void
    {
        $nameValidator = new LengthValidator(Kernel::post('name'), 'nom', 'm', 3, 30);
        $descriptionValidator = new LengthValidator(Kernel::post('description'), 'description', 'f', 10, 255);
        $dayValidator = new InArrayValidator(Kernel::post('day'), 'jour', 'm', Helper::$days);
        $hoursValidator = new LessonHoursValidator(Kernel::post('hourStart'), Kernel::post('hourEnd'));
        $constraints = Validator::constraintsValidator([$nameValidator, $descriptionValidator, $dayValidator, $hoursValidator]);
        if ($constraints->getPassed()){
            $lesson = new Lesson();
            $lesson->setName(Kernel::post('name'));
            $lesson->setDescription(Kernel::post('description'));
            $lesson->setDay(Kernel::post('day'));
            $lesson->setHourStart(Kernel::post('hourStart'));
            $lesson->setHourEnd(Kernel::post('hourEnd'));
            $lesson->setTrainerID(Kernel::post('trainer_id'));
            Kernel::getModel(Lesson::class)->insert($lesson);
            Templater::redirect("admin/planning");
        } else
        {
            $trainers = Kernel::getModel(Trainer::class)->getAll();
            $days = Helper::$days;
            Templater::render('admin/planning/add.html.php', ['active' => 'admin', 'title' => 'Administration', 'trainers' => $trainers, 'days' => $days, 'errors' => $constraints->getErrors()]);
        }
    }

    public function editLesson($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $lesson = Kernel::getModel(Lesson::class)->getById($id);
        if ($lesson == null)
        {
            Templater::redirect("404");
        } else
        {
            $trainers = Kernel::getModel(Trainer::class)->getAll();
            $days = Helper::$days;
            Templater::render('admin/planning/edit.html.php', ['active' => 'admin', 'title' => 'Administration', 'lesson' => $lesson, 'trainers' => $trainers, 'days' => $days]);
        }
    }

    public function postEditLesson($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $lesson = Kernel::getModel(Lesson::class)->getById($id);
        $nameValidator = new LengthValidator(Kernel::post('name'), 'nom', 'm', 3, 30);
        $descriptionValidator = new LengthValidator(Kernel::post('description'), 'description', 'f', 10, 255);
        $dayValidator = new InArrayValidator(Kernel::post('day'), 'jour', 'm', Helper::$days);
        $hoursValidator = new LessonHoursValidator(Kernel::post('hourStart'), Kernel::post('hourEnd'));
        $constraints = Validator::constraintsValidator([$nameValidator, $descriptionValidator, $dayValidator, $hoursValidator]);
        if ($constraints->getPassed())
        {
            $lesson->setName(Kernel::post('name'));
            $lesson->setDescription(Kernel::post('description'));
            $lesson->setDay(Kernel::post('day'));
            $lesson->setHourStart(Kernel::post('hourStart'));
            $lesson->setHourEnd(Kernel::post('hourEnd'));
            $lesson->setTrainerID(Kernel::post('trainer_id'));
            Kernel::getModel(Lesson::class)->update($lesson);
            Templater::redirect("admin/planning");
        } else
        {
            $trainers = Kernel::getModel(Trainer::class)->getAll();
            $days = Helper::$days;
            Templater::render('admin/planning/edit.html.php', ['active' => 'admin', 'title' => 'Administration', 'lesson' => $lesson, 'trainers' => $trainers, 'days' => $days, 'errors' => $constraints->getErrors()]);
        }
    }

    public function delLesson($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $lesson = Kernel::getModel(Lesson::class)->getById($id);
        Kernel::getModel(Lesson::class)->delete($lesson);
        header('Location: /admin/planning');
    }

    public function tarifs():void
    {
        $tarifs = Kernel::getModel(Tarif::class)->getAll();
        Templater::render('admin/tarifs/index.html.php', ['active' => 'admin', 'title' => 'Administration', 'tarifs' => $tarifs]);
    }

    public function editTarif($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $tarif = Kernel::getModel(Tarif::class)->getById($id);
        Templater::render('admin/tarifs/edit.html.php', ['active' => 'admin', 'title' => 'Administration', 'tarif' => $tarif]);
    }

    public function postEditTarif($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $tarif = Kernel::getModel(Tarif::class)->getById($id);
        $nameValidator = new LengthValidator(Kernel::post('name'), 'nom', 'm', 3, 20);
        $constraints = Validator::constraintsValidator([$nameValidator]);
        if ($constraints->getPassed())
        {
            $tarif->setName(Kernel::post('name'));
            $tarif->setPrice(Kernel::post('price'));
            Kernel::getModel(Tarif::class)->update($tarif);
            Templater::redirect("admin/tarifs");
        } else
        {
            Templater::render('admin/tarifs/edit.html.php', ['active' => 'admin', 'title' => 'Administration', 'tarif' => $tarif, 'errors' => $constraints->getErrors()]);
        }
    }

    public function users(): void
    {
        $users = Kernel::getModel(User::class)->getAll();
        Templater::render('admin/users/index.html.php', ['active' => 'admin', 'title' => 'Administration', 'users' => $users]);
    }

    public function participations(): void
    {
        $days = Helper::$days;
        $lessons = Kernel::getModel(Lesson::class)->getAll();
        $groupedLessons = Helper::groupLessonsByDays($lessons);
        Templater::render('admin/participations/index.html.php', ['active' => 'admin', 'title' => 'Administration', 'days' => $days, 'groupedLessons' => $groupedLessons]);
    }

    public function participationsLesson($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $lesson = Kernel::getModel(Lesson::class)->getById($id);
        Templater::render('admin/participations/lesson.html.php', ['active' => 'admin', 'title' => 'Administration', 'lesson' => $lesson]);
    }

}