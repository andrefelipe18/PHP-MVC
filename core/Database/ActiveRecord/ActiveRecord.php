<?php

declare(strict_types=1);

namespace Core\Database\ActiveRecord;

use App\Contracts\Database\ActiveRecord\ActiveRecordContract;
use App\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use ReflectionClass;

abstract class ActiveRecord implements ActiveRecordContract
{
    /** @var array<string|mixed> */
    protected array $attributes = [];
    protected string $table = '';
    public function __construct(
    ) {
        if(empty($this->table)) {
            $tableName = (new ReflectionClass($this))->getShortName(); // Get the class name
            $tableName = lcfirst($tableName); // Convert the first letter to lowercase
            $tableName = (string)preg_replace('/([a-z])([A-Z])/', '$1_$2', $tableName); // Convert camelCase to snake_case
            $this->table = strtolower($tableName); // Append an 's' to the table name
        }
    }

    public function getTable(): string
    {
        return $this->table ?? '';
    }

    /**
     * @return array<string|mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function __set(string $name, mixed $value): void // This method is called when writing attributes to inaccessible or non-existent properties.
    {
        $this->attributes[$name] = $value;
    }

    public function __get(string $name): mixed // This method is called when reading attributes from inaccessible or non-existent properties.
    {
        return $this->attributes[$name] ?? null;
    }
    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function execute(ActiveRecordExecuteContract $activeRecordExecuteInterface): mixed
    {
        return $activeRecordExecuteInterface->execute($this);
    }
}
