<?php

namespace Core;

class MethodExtract
{
    /**
     * @return array<string|int>
     */
    public static function extract($controller): array
    {
        $uri = Uri::resolve();

        $method = 'index';
        $sliceIndexStartFrom = 2;

        if (isset($uri[1])) {
            $method = $uri[1];
        }

        if($method === ''){
            $method = 'index';
        }

        if (!method_exists($controller, $method)) {
            $method = 'index';
            $sliceIndexStartFrom = 1;
        }

        return [
            $method,
            $sliceIndexStartFrom
        ];
    }
}