<?php

use Core\Database\ActiveRecord\ActiveRecord;
use Core\Database\ActiveRecord\FindAll;

it('must be able to find all records', function () {
    $conn = new PDO('sqlite::memory:');

    $conn->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT);');

    $conn->exec('INSERT INTO users (name) VALUES ("John Doe")');
    $conn->exec('INSERT INTO users (name) VALUES ("Jane Doe")');

    $user = (new UserFindAllTest())->execute(new FindAll(fields: 'name', limit: 1, offset: 1, connection: $conn));

    $query = $conn->query('SELECT * FROM users WHERE id = 2');

    $userName = $user[0]["name"];
    $queryName = $query->fetch()['name'];

    expect($userName)->toBe($queryName);
});

class UserFindAllTest extends ActiveRecord
{
    protected string $table = 'users';
}