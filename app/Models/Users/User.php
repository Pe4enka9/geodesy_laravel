<?php

namespace App\Models\Users;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Guarded(['id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected $casts = [
        'password' => 'hashed',
        'position' => UserPositionEnum::class,
        'role' => UserRoleEnum::class,
    ];
}
