<?php

use Core\Database\ActiveRecord\ActiveRecord;
use Core\Database\ActiveRecord\Insert;

it('must be able to insert a record', function () {
    $conn = new PDO('sqlite::memory:');

    $conn->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT);');

    $user = new UserInsertTest();

    $user->name = 'John Doe';

    $user->execute(new Insert(connection: $conn));

    $query = $conn->query('SELECT * FROM users WHERE id = 1');

    $userName = $user->name;

    $queryName = $query->fetch()['name'];

    expect($userName)->toBe($queryName);
});

class UserInsertTest extends ActiveRecord
{
    protected string $table = 'users';
}