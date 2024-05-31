<?php

declare(strict_types=1);

namespace Core\Database\ActiveRecord;

use App\Contracts\Database\ActiveRecord\ActiveRecordContract;
use App\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use App\Database\Connection\DatabaseConnection;
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
