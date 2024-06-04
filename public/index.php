<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

use Core\Application;
use Core\AppExtract;

try {
    (new Application(new AppExtract()))
        ->controllerResolve()
        ->viewResolve();

} catch (\Throwable $e) {
    $html = $whoops->handleException($e);
    echo $html;
}

