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
                'first_name' => 'Иван',
                'last_name' => 'Тихонов',
                'login' => 'admin',
                'password' => Hash::make('admin'),
                'role' => UserRoleEnum::OWNER,
            ],
            [
                'first_name' => 'Сергей',
                'last_name' => 'Петров',
                'login' => 'petrov',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::ADMIN,
            ],
            [
                'first_name' => 'Алексей',
                'last_name' => 'Сидоров',
                'login' => 'sidorov',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
            [
                'first_name' => 'Мария',
                'last_name' => 'Кузнецова',
                'login' => 'kuznetsova',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
            [
                'first_name' => 'Дмитрий',
                'last_name' => 'Волков',
                'login' => 'volkov',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
