<?php

namespace App\Controller;

use App\Router\Route;
use App\Router\Router;

abstract class AbstractController
{

    public function __construct(Router $router)
    {

        foreach($this->getRoutes() as $route){

            $router->register($route);

        }

    }

    /**
     * @return Route[]
     */
    public abstract function getRoutes(): array;

}