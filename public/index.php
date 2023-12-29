<?php
require_once "../vendor/autoload.php";
require_once "../framework/autoload.php";
require_once "../controllers/MainController.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/Controller404.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/SpaceObjectCreateController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/SpaceObjectDeleteController.php";
require_once "../controllers/SpaceObjectUpdateController.php";

require_once "../controllers/SpaceObjectTypeCreateController.php";

require_once "../controllers/SetWelcomeController.php";
require_once "../controllers/LoginController.php";
require_once "../controllers/LogoutController.php";

require_once "../middlewares/LoginRequiredMiddleware.php";

$loader = new \Twig\Loader\FilesystemLoader('../views');

$twig = new \Twig\Environment($loader, [
    "debug" => true // добавляем тут debug режим
]);

$twig->addExtension(new \Twig\Extension\DebugExtension()); 
$pdo = new PDO("mysql:host=localhost;dbname=j06795130_spaceobjects;charset=utf8", "j06795130_admin", "adminadmin");


$router = new Router($twig, $pdo);

 $router->add("/", MainController::class);
  
$router->add("/space-object/(?P<id>\d+)/image", ObjectController::class);
$router->add("/space-object/(?P<id>\d+)/info", ObjectController::class);
$router->add("/space-object/(?P<id>\d+)", ObjectController::class);
$router->add("/space-object/(?P<id>\d+)/delete", SpaceObjectDeleteController::class)->middleware(new LoginRequiredMiddleware());
    $router->add("/space-object/(?P<id>\d+)/edit", SpaceObjectUpdateController::class)->middleware(new LoginRequiredMiddleware());
    $router->add("/search", SearchController::class);
    $router->add("/login", LoginController::class);
    $router->add("/logout", LogoutController::class);
    $router->add("/set-welcome/", SetWelcomeController::class);
    $router->add("/create", SpaceObjectCreateController::class)->middleware(new LoginRequiredMiddleware());
    $router->add("/create/checkes", SpaceObjectCreateController::class)->middleware(new LoginRequiredMiddleware());
    $router->add("/createType",SpaceObjectTypeCreateController::class)->middleware(new LoginRequiredMiddleware());
  //$router->add("/space-object/create", SpaceObjectCreateController::class);
   //$router->add("/space-object/delete", SpaceObjectDeleteController::class)->middleware(new LoginRequiredMiddleware());
    //$router->add("/space-object/(?P<id>\d+)/edit", SpaceObjectUpdateController::class)->middleware(new LoginRequiredMiddleware());
    $router->get_or_default(Controller404::class);
?>


