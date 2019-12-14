<?php


namespace App;


use App\Entity\Lesson;
use App\Entity\User;
use Exception;

class Helper
{

    public static $days = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];

    /**
     * @param int $week
     * @param int $year
     * @return array
     */
    public static function generateDates(int $week, int $year): array
    {
        $firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
        if ($firstDayInYear<6)
        {
            $shift = -($firstDayInYear - 1) * 86400;
        }
        else
        {
            $shift = (8 - $firstDayInYear) * 86400;
        }
        if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
        $dates = [];
        foreach(self::$days as $index => $date)
        {
            $dates[$date] = date("d", mktime(0,0,0,1,$index + 1,$year)+$weekInSeconds+$shift);
        }
        return $dates;
    }

    /**
     * @param Lesson[] $lessons
     * @return array
     */
    public static function groupLessonsByDays(array $lessons): array
    {
        $grouped = array('lundi' => [],'mardi' => [],'mercredi' => [],'jeudi' => [],'vendredi' => [],'samedi' => []);
        foreach($lessons as $lesson)
        {
            $grouped[$lesson->getDay()][] = $lesson;
        }
        return $grouped;
    }

    /**
     * @param User $user
     * @return int
     * @throws Exception
     */
    public static function getUserAge(User $user): int
    {
        $am = explode('-', $user->getBirthdate()->format("Y-m-d"));
        $an = explode('/', date('d/m/Y'));

        if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[2] <= $an[0])))
            return $an[2] - $am[0];

        return $an[2] - $am[0] - 1;
    }

    /**
     * @param $object
     * @param $property
     * @return mixed
     */
    public static function forceGet($object, $property)
    {
        return call_user_func(\Closure::bind(
            function () use ($object, $property)
            {
                return $object->{$property} ?? null;
            },
            null,
            $object
        ));
    }

}