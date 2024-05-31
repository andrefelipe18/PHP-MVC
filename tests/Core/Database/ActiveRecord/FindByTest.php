<?php

use Core\Database\ActiveRecord\ActiveRecord;
use Core\Database\ActiveRecord\FindBy;

it('must be able to find a record by a field', function () {
    $conn = new PDO('sqlite::memory:');

    $conn->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT);');

    $conn->exec('INSERT INTO users (name) VALUES ("John Doe")');
    $conn->exec('INSERT INTO users (name) VALUES ("Jane Doe")');

    $user = (new UserFindByTest())->execute(new FindBy(field: 'id', value: 1, operator: '>', connection: $conn));

    $query = $conn->query('SELECT * FROM users WHERE id = 2');

    $userName = $user["name"];
    $queryName = $query->fetch()['name'];

    expect($userName)->toBe($queryName);
});

class UserFindByTest extends ActiveRecord
{
    protected string $table = 'users';
}