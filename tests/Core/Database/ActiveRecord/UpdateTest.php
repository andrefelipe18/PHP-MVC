<?php

use Core\Database\ActiveRecord\ActiveRecord;
use Core\Database\ActiveRecord\Update;

it('must be able to insert a record', function () {
    $conn = new PDO('sqlite::memory:');

    $conn->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT);');

    $conn->exec('INSERT INTO users (name) VALUES ("John Doe")');

    $user = new UserUpdateTest();

    $user->name = 'Jane Doe';

    $user->execute(new Update('id', '1', connection: $conn));

    $query = $conn->query('SELECT * FROM users WHERE id = 1');

    $userName = $user->name;

    $queryName = $query->fetch()['name'];

    expect($userName)->toBe($queryName);
});

class UserUpdateTest extends ActiveRecord
{
    protected string $table = 'users';
}