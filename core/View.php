<?php
class View {
    public $path;
    public $layout = 'default';
    public $route;
    public $Main = array();
    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }
    public function render($title, $vars = []) {
        extract($vars);
            if(file_exists('views/'.$this->path.'.php')) {
                ob_start();
                require 'views/'.$this->path.'.php';
                $content = ob_get_clean();
                require 'views/layouts/'.$this->layout.'.php';
            }

        else {
            echo "Шаблон не найден".$this->path;
        }



    }
}