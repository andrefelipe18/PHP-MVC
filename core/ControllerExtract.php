<?php

namespace Core;

class ControllerExtract
{
    public static function extract(): string
    {
        $uri = Uri::resolve();

        $controller = 'Home';

        if(isset($uri[0]) && $uri[0] !== ''){
            $controller = ucfirst($uri[0]);
        }

        $namespace = 'App\\Controllers\\' . $controller;

        if(class_exists($namespace)){
            $controller = $namespace;
        }

        return $controller;
    }
}