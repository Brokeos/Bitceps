<?php


namespace App\Controller;


use App\Entity\Lesson;
use App\Entity\Participation;
use App\Entity\Trainer;
use App\Helper;
use App\Kernel;
use App\Router\Route;
use App\Templater;
use DateTime;

class PlanningController extends AbstractController
{

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
       return [
           new Route('planning','/planning', ['GET'] , function() { self::index(); }),
           new Route('planning.trainer','/planning/{id}', ['GET'], function($id){ self::showTrainer($id); })
       ];
    }

    public function index(): void
    {
        $date = new DateTime('now');
        $dates = Helper::generateDates($date->format("W"), $date->format('Y'));
        $lessons = Kernel::getModel(Lesson::class)->getAll();
        $groupedLessons = Helper::groupLessonsByDays($lessons);
        $participations = [];
        if (Kernel::isAuthed())
        {
            $_participations = Kernel::getModel(Participation::class)->getByUser(Kernel::getUser());
            foreach ($_participations as $participation)
            {
                array_push($participations, $participation->getLessonId());
            }
        }
        Templater::render('planning/index.html.php', ['active' => 'planning', 'title' => 'Planning', 'dates' => $dates, 'groupedLessons' => $groupedLessons, 'participations' => $participations]);
    }

    public function showTrainer($id): void
    {
        if (intval($id) != $id)
            Templater::redirect('404');
        $trainer = Kernel::getModel(Trainer::class)->getById($id);
        if ($trainer == null)
        {
            Templater::redirect("404");
        } else
        {
            $date = new DateTime('now');
            $dates = Helper::generateDates( $date->format("W"), $date->format('Y'));
            $groupedLessons = Helper::groupLessonsByDays($trainer->getLessons());
            $participations = [];
            if (Kernel::isAuthed())
            {
                $_participations = Kernel::getModel(Participation::class)->getByUser(Kernel::getUser());
                foreach ($_participations as $participation)
                {
                    array_push($participations, $participation->getLessonId());
                }
            }
            Templater::render('planning/index.html.php', ['active' => 'planning', 'title' => 'Planning', 'dates' => $dates, 'groupedLessons' => $groupedLessons, 'participations' => $participations]);
        }
    }

}