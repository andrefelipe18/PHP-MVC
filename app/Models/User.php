<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database\ActiveRecord\ActiveRecord;

class User extends ActiveRecord
{
    protected string $table = 'users';
}