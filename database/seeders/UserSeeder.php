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
                'name' => 'Иван Тихонов',
                'login' => 'admin',
                'password' => Hash::make('admin'),
                'role' => UserRoleEnum::OWNER,
            ],
            [
                'name' => 'Петров Сергей',
                'login' => 'petrov',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::ADMIN,
            ],
            [
                'name' => 'Сидоров Алексей',
                'login' => 'sidorov',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
            [
                'name' => 'Кузнецова Мария',
                'login' => 'kuznetsova',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::EMPLOYEE,
                'position' => UserPositionEnum::SURVEYOR,
            ],
            [
                'name' => 'Волков Дмитрий',
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
