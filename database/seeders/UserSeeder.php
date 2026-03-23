<?php

namespace Database\Seeders;

use App\Enums\Users\Position;
use App\Enums\Users\Role;
use App\Models\User;
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
                'role' => Role::ADMIN,
            ],
            [
                'name' => 'Петров Сергей',
                'login' => 'petrov',
                'password' => Hash::make('password'),
                'role' => Role::MANAGER,
                'position' => Position::FOREMAN,
            ],
            [
                'name' => 'Сидоров Алексей',
                'login' => 'sidorov',
                'password' => Hash::make('password'),
                'role' => Role::EMPLOYEE,
                'position' => Position::SURVEYOR,
            ],
            [
                'name' => 'Кузнецова Мария',
                'login' => 'kuznetsova',
                'password' => Hash::make('password'),
                'role' => Role::EMPLOYEE,
                'position' => Position::SURVEYOR,
            ],
            [
                'name' => 'Волков Дмитрий',
                'login' => 'volkov',
                'password' => Hash::make('password'),
                'role' => Role::EMPLOYEE,
                'position' => Position::SURVEYOR,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
