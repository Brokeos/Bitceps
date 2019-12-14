<?php


namespace App\Model;


use App\Entity\Lesson;
use App\Entity\Tarif;

class TarifModel extends Model
{

    public function __construct()
    {
        parent::__construct(Tarif::class);
    }

}