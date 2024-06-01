<?php

namespace Core;

class AppExtract
{
    /** @var array<string>  */
    public array $uri = [];
    private string $controller = 'Home';
    private string $method = 'index';
    /** @var array<string, mixed>  */
    private array $params = [];

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

    public function method(): string
    {
        if(isset($this->uri[1]) && $this->uri[1] !== ''){
            $this->method = strtolower($this->uri[1]);
        }

        if(!method_exists($this->controller, $this->method)){
            $this->method = 'index';
        }

        return $this->method;
    }

    /**
     * @return array<string, mixed>
     */
    public function params(): array
    {

    }
}