<?php

declare(strict_types=1);

namespace Core\Database\ActiveRecord;

use Core\Contracts\Database\ActiveRecord\ActiveRecordContract;
use Core\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use Core\Database\Connection\DatabaseConnection;
use Exception;
use PDO;
use RuntimeException;

class Update implements ActiveRecordExecuteContract
{
    public function __construct(
        private readonly string $field,
        private readonly mixed $value,
        private readonly ?PDO $connection = null
    ) {
    }
    public function execute(ActiveRecordContract $activeRecordInterface): mixed
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = ($this->connection) ?: DatabaseConnection::connect();
            $attributes = array_merge($activeRecordInterface->getAttributes(), [$this->field => $this->value]);
            $prepare = $connection->prepare($query); //Prepare query
            $prepare->execute($attributes); //Execute query
            return $prepare->rowCount(); //Return affected rows count
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function createQuery(ActiveRecordContract $activeRecordInterface): string
    {
        $sql = "UPDATE {$activeRecordInterface->getTable()} SET ";

        foreach ($activeRecordInterface->getAttributes() as $key => $value) {
            if ($key !== 'id') {
                $sql .= $key . ' = :' . $key . ', ';
            }
        }

        $sql = rtrim($sql, ', '); //Remove trailing comma and space

        $sql .= " WHERE {$this->field} = :{$this->field}";

        return $sql;
    }
}
