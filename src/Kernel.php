<?php


namespace App;

use App\Controller\AdminController;
use App\Controller\ErrorController;
use App\Controller\HomeController;
use App\Controller\PlanningController;
use App\Controller\SecurityController;
use App\Controller\UserController;
use App\Entity\Lesson;
use App\Entity\Participation;
use App\Entity\Tarif;
use App\Entity\Trainer;
use App\Entity\User;
use App\Model\LessonModel;
use App\Model\Model;
use App\Model\ParticipationModel;
use App\Model\TarifModel;
use App\Model\TrainerModel;
use App\Model\UserModel;
use App\Repository\AbstractRepository;
use App\Repository\LessonRepository;
use App\Repository\ParticipationRepository;
use App\Repository\TarifRepository;
use App\Repository\TrainerRepository;
use App\Repository\UserRepository;
use App\Router\Route;
use App\Router\Router;
use PDO;

class Kernel
{

    /**
     * @var Router
     */
    public static $router;
    private static $database;
    private static $authed = false;
    private static $user;

    /**
     * @var AbstractRepository[]
     */
    private static $repositories;

    /**
     * @var Model[]
     */
    private static $models;

    public function __construct()
    {
        session_start();
        $this->initialiseDatabase();
        $this->initialiseRouter();
        $this->initialiseModels();
        if ($_SESSION['authed'] ?? false)
        {
            self::$authed = true;
            self::$user = self::getModel(User::class)->getById($_SESSION['userid']);
        }
        $this->initialiseControllers();
        set_error_handler(function()
        {
            Templater::redirect('404');
        });
    }

    private function initialiseRouter(): void
    {
        self::$router = new Router(isset($_GET['url'])?$_GET['url']:"/");
    }

    private function initialiseControllers(): void
    {
        new AdminController(self::$router);
        new ErrorController(self::$router);
        new HomeController(self::$router);
        new PlanningController(self::$router);
        new SecurityController(self::$router);
        new UserController(self::$router);
    }

    private function initialiseDatabase(): void
    {
        try
        {
            self::$database = new PDO("mysql:host=" . Config::$mysql['host'] .";dbname=" . Config::$mysql['database'] . ";", Config::$mysql['username'], Config::$mysql['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ));
        } catch (\Exception $e)
        {
            echo 'Impossible de se connecter à la base de donnée';
            exit;
        }
    }

    public static function getDatabase(): PDO
    {
        return self::$database;
    }

    private function initialiseModels(): void
    {
        self::$models[Lesson::class] = new LessonModel();
        self::$models[Participation::class] = new ParticipationModel();
        self::$models[Tarif::class] = new TarifModel();
        self::$models[Trainer::class] = new TrainerModel();
        self::$models[User::class] = new UserModel();
    }

    public static function getModel($class): Model
    {
        return self::$models[$class];
    }

    public static function generateError(int $id): void
    {
        echo $id;
        exit;
    }

    public static function post(string $key, string $default = ''): string
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * @return bool
     */
    public static function isAuthed(): bool
    {
        return self::$authed;
    }

    /**
     * @return User
     */
    public static function getUser(): ?User
    {
        return self::$user;
    }

}