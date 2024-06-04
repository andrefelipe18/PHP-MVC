<?php

namespace Core\Contracts;

interface ControllerContract
{
    public function controller(): string;
    public function method($controller): string;
    public function params(): array;
}