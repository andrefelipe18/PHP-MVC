<?php

use Core\Database\Connection\DatabaseConnection;

afterEach(function () {
    DatabaseConnection::disconnect();
});

it('should connect to the database', function () {
    $pdo = Mockery::mock(PDO::class);
    $this->assertNotNull(DatabaseConnection::connect($pdo));
});

it('should return the same connection', function () {
    $pdo = Mockery::mock(PDO::class);
    $this->assertSame(DatabaseConnection::connect($pdo), DatabaseConnection::connect($pdo));
});

it('should throw an exception when connecting to the database', function () {
    $this->expectException(PDOException::class);
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_NAME'] = 'wrong_db_name';
    $_ENV['DB_USER'] = 'root';
    $_ENV['DB_PASS'] = 'root';
    $_ENV['DB_PORT'] = '3306';
    DatabaseConnection::connect();
});

it('should create a new connection when none exists', function () {
    $this->expectException(PDOException::class);
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_NAME'] = 'test_db_name';
    $_ENV['DB_USER'] = 'root';
    $_ENV['DB_PASS'] = 'root';
    $_ENV['DB_PORT'] = '3306';

    DatabaseConnection::connect();
});

it('should disconnect from the database', function () {
    $pdo = Mockery::mock(PDO::class)->makePartial();
    DatabaseConnection::connect($pdo);
    DatabaseConnection::disconnect();

    $reflection = new ReflectionClass(DatabaseConnection::class);
    $property = $reflection->getProperty('pdo');
    $this->assertNull($property->getValue());
});

it('should not be able to instantiate the class', function () {
    $reflection = new ReflectionClass(DatabaseConnection::class);
    $this->assertFalse($reflection->isInstantiable());
});

it('should not be able to clone the class', function () {
    $reflection = new ReflectionClass(DatabaseConnection::class);
    $this->assertFalse($reflection->isCloneable());
});

it('should disconnect and then connect again', function () {
    $pdo = Mockery::mock(PDO::class)->makePartial();
    DatabaseConnection::connect($pdo);
    DatabaseConnection::disconnect();

    $reflection = new ReflectionClass(DatabaseConnection::class);
    $property = $reflection->getProperty('pdo');
    $property->setAccessible(true);
    $this->assertNull($property->getValue());

    DatabaseConnection::connect($pdo);
    $this->assertNotNull($property->getValue());
});