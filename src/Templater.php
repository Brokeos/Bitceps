<?php


namespace App;

class Templater
{

    public static function render(string $view, array $parameters = []): void
    {
        extract($parameters);
        include ROOT . "/view/{$view}";
    }

    public static function asset(String $path): string
    {
        return Config::$site['base-url'] . "assets/" . $path;
    }

    public static function url(String $name, array $data = []): string
    {
        $route = Kernel::$router->getByName($name);
        if ($route == null)
        {
            ob_clean();
            throw new \Exception("Route " . $name . " not found");
        }
        return Config::$site['base-url'] . $route->createUrl($data);
    }

    public static function redirect(String $path, int $time = 0): void
    {
        if ($time == 0)
        {
            header('Location: ' . Config::$site['base-url'] . $path, true, 301);
        } else
        {
            header('refresh:' . $time .';url=' . Config::$site['base-url'] . $path);
        }
    }

    public static function buildPrimaryNavbar(String $active): string
    {

        $tree = array(
            'home' => array('Accueil', self::url('home')),
            'tarifs' => array('Nos Tarifs', self::url('tarifs')),
            'planning' => array('Planning', self::url('planning'))
        );

        $output = "";

        foreach($tree as $key => $value){

            $output .= "<li" . ($key == $active ? " class=\"current\"" : "") . "><a href=\"{$value[1]}\"><div>{$value[0]}</div></a></li>\n" ;

        }

        return $output;

    }

    public static function buildConnectNavbar(string $active): string
    {

        $output = "";

         if (Kernel::isAuthed()){

            $output = '<li' . ($active == "profile" ? ' class="current" ' : "") . ' style="border-left: 1px solid #EEE;"><a href="' . Templater::url('user.profile') . '">Mon profil</a></li>';
            $output .= '<li><a href="' . Templater::url('security.logout') . '">Déconnexion</a></li>';

            if (Kernel::getUser()->getIsAdmin())
            {

                $output .= '<li' . ($active == "admin" ? ' class="current" ' : "") . ' style="border-left: 1px solid #EEE;"><a href="' . Templater::url('admin.home') . '">Administration</a></li>';
                
            }
            
         } else
         {

             $output = '<li' . ($active == "login" ? ' class="current" ' : "") . ' style="border-left: 1px solid #EEE;"><a href="' .  Templater::url('security.login') . '">Connexion</a></li>';

         }

         return $output;

    }

}

$parameters = null;