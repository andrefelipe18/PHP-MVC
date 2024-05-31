<?php

use Core\Database\ActiveRecord\ActiveRecord;
use Core\Database\ActiveRecord\Delete;

it('must be able to delete a record', function () {
    $conn = new PDO('sqlite::memory:');

    //Create a table
    $conn->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT);');

    //Insert some data
    $conn->exec('INSERT INTO users (name) VALUES ("John Doe")');

    $delete = (new UserDeleteTest)->execute((new Delete('id', 1, $conn)));

    expect($delete)->toBe(1);

    $query = $conn->query('SELECT * FROM users');

    expect($query->fetchAll())->toBe([]);

    $conn->exec('DROP TABLE users');
});

class UserDeleteTest extends ActiveRecord
{
    protected string $table = 'users';
}