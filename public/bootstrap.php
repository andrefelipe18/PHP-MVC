<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$whoops = new \Whoops\Run;
$whoops->allowQuit(false);
$whoops->writeToOutput(false);
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);