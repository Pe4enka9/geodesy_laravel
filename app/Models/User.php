<?php

namespace App\Models;

use App\Enums\Users\Position;
use App\Enums\Users\Role;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Guarded(['id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected $casts = [
        'password' => 'hashed',
        'position' => Position::class,
        'role' => Role::class,
    ];
}
