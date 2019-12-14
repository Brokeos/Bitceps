<?php
/**
 * Created by PhpStorm.
 * User: rgautr01
 * Date: 09/08/2017
 * Time: 20:29
 */

namespace App\Router;

use App\Config;
use App\Templater;

class Router
{

    private $url;
    private $routes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function register(Route $route)
    {
        foreach($route->getMethods() as $method){
            $method = strtoupper($method);
            $this->routes[$method][] = $route;
        }
    }

    public function getByName(string $name): ?Route
    {
        foreach ($this->routes as $method)
        {
            foreach($method as $route)
            {
                if ($route->getName() == $name)
                {
                    return $route;
                }
            }
        }
        return null;
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
        {
            throw new \Exception("Invalid REQUEST_METHOD " . $_SERVER['REQUEST_METHOD']);
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
        {
            if ($route->match($this->url))
            {
                return $route->call();
            }
        }
        Templater::redirect("404");
    }

}