<?php

declare(strict_types=1);

namespace Core\Database\ActiveRecord;

use App\Contracts\Database\ActiveRecord\ActiveRecordContract;
use App\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use App\Database\Connection\DatabaseConnection;
use Exception;
use PDO;
use RuntimeException;

class Insert implements ActiveRecordExecuteContract
{
    public function __construct(
        private readonly ?PDO $connection = null
    ) {
    }
    public function execute(ActiveRecordContract $activeRecordInterface): mixed
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = ($this->connection) ?: DatabaseConnection::connect();

            $prepare = $connection->prepare($query);

            $prepare->execute($activeRecordInterface->getAttributes());

            return $connection->lastInsertId();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function createQuery(ActiveRecordContract $activeRecordInterface): string
    {
        $table = $activeRecordInterface->getTable();

        $attributes = $activeRecordInterface->getAttributes();

        $columns = implode(', ', array_keys($attributes));

        $values = implode(', :', array_keys($attributes));

        return "INSERT INTO {$table} ({$columns}) VALUES (:{$values})";
    }
}
