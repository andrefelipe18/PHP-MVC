<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

session_start();

echo $_ENV['DB_HOST'];