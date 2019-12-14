<?php


namespace App\Model;


use App\Entity\Trainer;

class TrainerModel extends Model
{

    public function __construct()
    {
        parent::__construct(Trainer::class);
    }

}