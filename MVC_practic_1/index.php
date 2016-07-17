<?php

require_once 'Route.php';
require_once 'Controller.php';
require_once 'View.php';
require_once 'Model.php';

final class App {
    static private $instance;
    private $routes_list = [];
    private $view;
    private $config;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getView()
    {
        return $this->view;
    }

    public function init($config_path) {
        $this->config = require_once $config_path;
        $this->view = new View($this->config['templates_path'], $this->config['templates_ext']);
    }

    public function addRoute($uri, $controller_cls, $action_name = 'index') {
        $controller = new $controller_cls();
        $this->routes_list[] = new Route($uri, $controller, $action_name);
    }

    public function inspect() {
        $uri_params = explode('?', $_SERVER['REQUEST_URI']);
        $route_path = $uri_params[0];
        /**
         * @var Route $route
         */
        foreach ($this->routes_list as $route) {
            if ($route->inspect($route_path)) {
                return $route->callAction();
            }
        }
        return false;
    }
}

final class UserModel extends Model {
    private $name = 'Dima';

    public function getUserProfile() {
        return [
            'name' => $this->name,
        ];
    }

    public function setUserName($name) {
         $this->name = $name;
    }
}

final class TestController extends Controller {
    public function index() {
//        UserModel::getModel()->setUserName('Mike');
        $user_info = UserModel::getModel()->getUserProfile();
        return $this->app->getView()->render('main', $user_info);
    }

    public function test2() {
        return $this->app->getView()->render('test_page', []);
    }
}

$app = App::getInstance();
$app->init('config.php');
$app->addRoute('/1', TestController::class);
$app->addRoute('/2', TestController::class, 'test');
$page = $app->inspect();
if ($page === false) {
    http_response_code(404);
    echo $app->getView()->render('404', []);
} else {
    echo $page;
}



