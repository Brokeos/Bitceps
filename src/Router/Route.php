<?php
/**
 * Created by PhpStorm.
 * User: rgautr01
 * Date: 09/08/2017
 * Time: 20:29
 */

namespace App\Router;

class Route
{

    private $name;
    private $path;
    private $methods;
    private $callable;
    private $matches = [];

    public function __construct($name, $path, $methods, $callable)
    {
        $this->name = $name;
        $this->path = trim($path, '/');
        $this->methods = $methods;
        $this->callable = $callable;
    }

    /**
     * @return mixed
     */
    public function getMethods()
    {
        return $this->methods;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#{([\w]+)}#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches))
        {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function createUrl(array $data = []): string
    {
        $url = $this->path;
        foreach ($data as $key => $value)
        {
            $url = str_replace("{" . $key . "}", $value, $url);
        }
        $regex = "#{[\w]+}$#";
        if (!preg_match($regex, $url, $matches))
        {
            return $url;
        }
        ob_clean();
        throw new \Exception("Missing args : " . implode($matches));
        exit;
    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}