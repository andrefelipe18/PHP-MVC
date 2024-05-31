<?php

declare(strict_types=1);

namespace Core\Contracts\Database\ActiveRecord;

interface ActiveRecordContract
{
    public function __set(string $name, mixed $value): void;
    public function __get(string $name): mixed;
    public function getTable(): string;

    /**
     * @return array<string, mixed>
     */
    public function getAttributes(): array;
    public function execute(ActiveRecordExecuteContract $activeRecordExecuteInterface): mixed;
}
