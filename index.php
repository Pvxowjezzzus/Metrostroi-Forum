<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require 'core/Router.php';
$router = new Router;
$router->launch();
?>