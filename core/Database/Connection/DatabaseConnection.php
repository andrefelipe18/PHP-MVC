<?php

declare(strict_types=1);

namespace Core\Database\Connection;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $pdo = null;
    private function __construct()
    {
    }
    private function __clone()
    {
    }

    /**
     * @param PDO|null $testingPDO
     * @return PDO
     * @throws PDOException
     */
    public static function connect(?PDO $testingPDO = null): PDO
    {
        if (self::$pdo === null) {
            try {

                if($testingPDO !== null) {
                    self::$pdo = $testingPDO;
                    return self::$pdo;
                }

                self::$pdo = self::createConnection();

                return self::$pdo;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$pdo;
    }

    private static function createConnection(): PDO
    {
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $port = $_ENV['DB_PORT'];

        return new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }

    public static function disconnect(): void
    {
        self::$pdo = null;
    }
}
