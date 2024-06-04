<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

try {
    $app = new \Core\AppExtract();
    $controller = $app->controller();
    $method = $app->method();
    $params = $app->params();

    $controller = new $controller();
    $controller->$method($params);

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(!isset($controller->data)){
            throw new \RuntimeException('Controller needs to have a $data property');
        }

        if(!array_key_exists('title', $controller->data)){
            throw new \RuntimeException('Controller needs to have a $data property');
        }

        extract($controller->data);
        require __DIR__ . '/../app/Views/layout.views.php';
    }
} catch (\Throwable $e) {
    $html = $whoops->handleException($e);
    echo $html;
}

