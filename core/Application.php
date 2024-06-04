<?php

namespace Core;

use Core\Contracts\ControllerContract;

class Application
{
    private $controller;
    public function __construct(
        private ControllerContract $controllerContract
    ){}

    public function controllerResolve(): Application
    {
        $controller = $this->controllerContract->controller();
        $method = $this->controllerContract->method();
        $params = $this->controllerContract->params();

        $this->controller = new $controller();
        $this->controller->$method($params);
        return $this;
    }

    public function viewResolve()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(!isset($this->controller->data)){
                throw new \RuntimeException('Controller needs to have a $data property');
            }

            if(!array_key_exists('title', $this->controller->data)){
                throw new \RuntimeException('Controller needs to have a $data property');
            }

            extract($this->controller->data);
            require __DIR__ . '/../app/Views/layout.views.php';
        }
    }
}