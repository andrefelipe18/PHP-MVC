<?php

namespace Core;

use Core\Contracts\ControllerContract;

class AppExtract implements ControllerContract
{
    private int $sliceIndexStartFrom = 0;

    public function controller(): string
    {
        return ControllerExtract::extract();
    }

    public function method($controller): string
    {
        [$method, $sliceIndexStartFrom] = MethodExtract::extract($controller);
        $this->sliceIndexStartFrom = $sliceIndexStartFrom;
        return $method;
    }

    /**
     * @return array<string, mixed>
     */
    public function params(): array
    {
        $uri = Uri::resolve();
        return array_slice($uri, $this->sliceIndexStartFrom, count($uri));
    }
}