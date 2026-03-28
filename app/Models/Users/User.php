<?php

namespace App\Models\Users;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
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

    public function isAdmin(): bool
    {
        return $this->role === UserRoleEnum::ADMIN;
    }

    public function isOwner(): bool
    {
        return $this->role === UserRoleEnum::OWNER;
    }

    public function newEloquentBuilder($query): Builder
    {
        return new UserQueryBuilder($query);
    }
}
