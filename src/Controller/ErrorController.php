<?php


namespace App\Controller;


use App\Router\Route;
use App\Templater;

class ErrorController extends AbstractController
{

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return [
            new Route('error.404', '/404', ['GET'], function() { self::_404(); }),
        ];
    }

    public function _404(): void
    {
        header('HTTP/1.1 404 Not Found');
        Templater::render('error/404.html.php', ['active' => 'error', 'title' => '404']);
    }

}