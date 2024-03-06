<?php
require_once '../helpers.php';
require basePath('Router.php');
require basePath('Database.php');
// loadView('home');
// inspect($method);
$router=new Router();
$routes=require basePath('routes.php');
$uri=$_SERVER['REQUEST_URI'];
$method=$_SERVER['REQUEST_METHOD'];
$router->route($uri,$method);
?>