<?php

namespace Core;

class Uri
{
    /**
     * @return string[]
     */
    public static function resolve(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return explode('/', ltrim($uri, '/'));
    }
}