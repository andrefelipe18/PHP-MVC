<?php

namespace Core;

class AppExtract
{
    public array $uri = [];
    private string $controller = 'Home';

    public function controller(): string
    {
        $this->uri = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
        if(isset($this->uri[0]) && $this->uri[0] !== ''){
            $this->controller = ucfirst($this->uri[0]);
        }

        $namespace = 'App\\Controllers\\' . $this->controller;

        if(class_exists($namespace)){
            $this->controller = $namespace;
        }

        return $this->controller;
    }

    public function method()
    {
        
    }

    public function params()
    {
        
    }
}