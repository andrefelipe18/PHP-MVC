<?php

namespace App\Controllers;

class Home
{
    public array $data = [];
    public string $view = 'home.php';
    public function index()
    {
        $this->view = 'home.php';
        $this->data = [
            'name' => 'John Doe',
        ];
    }
}