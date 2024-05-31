<?php

declare(strict_types=1);

namespace Core\Database\ActiveRecord;

use App\Contracts\Database\ActiveRecord\ActiveRecordContract;
use App\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use App\Database\Connection\DatabaseConnection;
use Exception;
use PDO;
use RuntimeException;

class Delete implements ActiveRecordExecuteContract
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

            $prepare = $connection->prepare($query);

            $prepare->execute([$this->field => $this->value]);

            return $prepare->rowCount();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function createQuery(ActiveRecordContract $activeRecordInterface): string
    {
        if ($activeRecordInterface->getAttributes()) {
            throw new RuntimeException('To delete, you don t need to set any attributes');
        }

        return "DELETE FROM {$activeRecordInterface->getTable()} WHERE {$this->field} = :{$this->field}";
    }
}
