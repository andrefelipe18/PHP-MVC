<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$app = new \Core\AppExtract();
$controller = $app->controller();
$method = $app->method();
$params = $app->params();

var_dump($controller);
echo '<br>';
var_dump($method);
echo '<br>';
var_dump($params);  

//require __DIR__ . '/../app/Views/layout.views.php';
