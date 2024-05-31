<?php

use Core\Contracts\Database\ActiveRecord\ActiveRecordContract;
use Core\Contracts\Database\ActiveRecord\ActiveRecordExecuteContract;
use Core\Database\ActiveRecord\ActiveRecord;

it('should return the table name when is not set', function () {
    $user = new TestingUser();
    $this->assertEquals('testing_user', $user->getTable());
});

it('should return the table name when is set', function () {
    $user = new TestingUserWithTable();
    $this->assertEquals('users', $user->getTable());
});

it('should return the attributes', function () {
    $user = new TestingUser();
    $user->name = 'John Doe';
    $user->email = 'john@email';

    $this->assertEquals([
        'name' => 'John Doe',
        'email' => 'john@email'
    ], $user->getAttributes());
});

it('should set the attribute', function () {
    $user = new TestingUser();
    $user->name = 'John Doe';
    $this->assertEquals('John Doe', $user->name);
});

it('should get the attribute', function () {
    $user = new TestingUser();
    $user->name = 'John Doe';
    $this->assertEquals('John Doe', $user->name);
});

it('should check if the attribute is set', function () {
    $user = new TestingUser();
    $user->name = 'John Doe';
    $this->assertTrue(isset($user->name));
});

it('should check if the attribute is not set', function () {
    $user = new TestingUser();
    $this->assertFalse(isset($user->name));
});

it('should be able to execute a query', function () {
    $user = new TestingUser();

    $execute = new Execute();

    $this->assertEquals('Executed', $user->execute($execute));
});


class TestingUser extends ActiveRecord
{}

class TestingUserWithTable extends ActiveRecord
{
    protected string $table = 'users';
}

class Execute implements ActiveRecordExecuteContract
{
    public function execute(ActiveRecordContract $activeRecordInterface): string
    {
        return 'Executed';
    }
}