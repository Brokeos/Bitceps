<?php

namespace App\Controller;

use App\Entity\Tarif;
use App\Entity\Trainer;
use App\Entity\User;
use App\Kernel;
use App\Router\Route;
use App\Templater;

class HomeController extends AbstractController {

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return [
            new Route('home', '/', ['GET'], function() { self::index(); }),
            new Route('', '/home', ['GET'], function() { self::index(); }),
            new Route('tarifs', '/tarifs', ['GET'], function() { self::tarif(); }),
        ];
    }

    public function index(): void
    {
        $trainers = Kernel::getModel(Trainer::class)->getAll();
        $tarif = Kernel::getModel(Tarif::class)->getById(3);
        Templater::render('home/index.html.php', ['active' => 'home', 'title' => 'Accueil', 'trainers' => $trainers, 'tarif' => $tarif]);
    }

    public function tarif(): void
    {
        $tarifs = Kernel::getModel(Tarif::class)->getAll();
        Templater::render('home/tarifs.html.php', ['active' => 'tarifs', 'title' => 'Nos Tarifs', 'tarifs' => $tarifs]);
    }

}