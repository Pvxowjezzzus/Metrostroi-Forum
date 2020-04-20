<?php
class Router
{
    protected $routes = [];
    protected $params = [];
    function __construct() {
        $arr = require 'config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params) {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;

    }
    public function check() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {

            if(preg_match($route, $url,$matches)) {
                $this->params = $params;
                return true;
            }

        }
        return false;
    }

    public function launch() {
       if ($this->check()) {
           $nameController = ucfirst($this->params['controller']).'Controller';
           $pathController = 'controllers/'.$nameController.'.php';

           if (file_exists($pathController))
           {
               include_once $pathController;
               $controller = new $nameController($this->params);

               if (class_exists($nameController))
               {
                   $action = $this->params['action'];

                   if (method_exists($nameController, $action))
                   {
                       $controller->$action();

                   } else {
                       echo "Не удалось вызвать экшен: ".$action;
                   }

               } else {
                   echo "Не удалось загрузить контроллер: ".$nameController;
               }

           } else {
               echo "Не удалось найти файл контроллера: " . $pathController;
           }
        }
    }

}

?>