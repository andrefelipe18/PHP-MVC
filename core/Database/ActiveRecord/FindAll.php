<?php

declare(strict_types=1);

namespace Core\Database\ActiveRecord;

use Core\Contracts\Database\ActiveRecord\ActiveRecordContract;
use Core\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use Core\Database\Connection\DatabaseConnection;
use Exception;
use PDO;
use RuntimeException;

class FindAll implements ActiveRecordExecuteContract
{
    public function __construct(
        /** @var array<string, mixed> $where */
        private array $where = [],
        private string $fields = '*',
        private ?int $limit = null,
        private ?int $offset = null,
        private readonly ?PDO $connection = null
    ) {
    }
    public function execute(ActiveRecordContract $activeRecordInterface): mixed
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = ($this->connection) ?: DatabaseConnection::connect();

            $prepare = $connection->prepare($query);

            $prepare->execute($this->where);

            return $prepare->fetchAll();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function createQuery(ActiveRecordContract $activeRecordInterface): string
    {
        $where = '';
        if ($this->where) {
            $where = 'WHERE ';
            foreach ($this->where as $field => $value) {
                $where .= "{$field} = :{$field} AND ";
            }
            $where = substr($where, 0, -4);
        }

        $limit = ($this->limit) ? "LIMIT {$this->limit}" : '';

        $offset = ($this->offset) ? "OFFSET {$this->offset}" : '';

        return "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()} {$where} {$limit} {$offset}";
    }
}
