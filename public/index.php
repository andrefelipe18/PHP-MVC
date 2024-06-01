<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$app = new \Core\AppExtract();
$controller = $app->controller();
$method = $app->method();

var_dump($method);
echo '<br>';
var_dump($controller);

//require __DIR__ . '/../app/Views/layout.views.php';
