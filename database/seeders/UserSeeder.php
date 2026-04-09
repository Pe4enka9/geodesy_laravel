<?php

namespace Database\Seeders;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Иванов',
                'last_name' => 'Иван',
                'login' => 'owner',
                'password' => Hash::make('owner'),
                'role' => UserRoleEnum::OWNER,
            ],
            [
                'first_name' => 'Сергей',
                'last_name' => 'Петров',
                'login' => 'admin',
                'password' => Hash::make('admin'),
                'role' => UserRoleEnum::ADMIN,
            ],
            [
                'first_name' => 'Алексей',
                'last_name' => 'Сидоров',
                'login' => 'user1',
                'password' => Hash::make('user'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
            [
                'first_name' => 'Мария',
                'last_name' => 'Кузнецова',
                'login' => 'user2',
                'password' => Hash::make('user'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
            [
                'first_name' => 'Дмитрий',
                'last_name' => 'Волков',
                'login' => 'user3',
                'password' => Hash::make('user'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::FOREMAN,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
