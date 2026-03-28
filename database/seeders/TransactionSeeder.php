<?php

namespace Database\Seeders;

use App\Models\Equipments\Equipment;
use App\Models\Transactions\Enums\TransactionTypeEnum;
use App\Models\Transactions\Transaction;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = Equipment::all();
        $users = User::all();
        $admin = User::where('role', 'admin')->first();

        foreach ($equipments as $equipment) {
            // Имитируем выдачу со склада месяц назад
            if ($equipment->current_holder_id) {
                Transaction::create([
                    'equipment_id' => $equipment->id,
                    'type' => TransactionTypeEnum::CHECKOUT,
                    'from_user_id' => null, // Со склада
                    'to_user_id' => $equipment->current_holder_id,
                    'occurred_at' => Carbon::today()->subDays(rand(5, 30)),
                    'comment' => 'Плановая выдача на объект',
                    'created_by' => $admin->id,
                ]);
            }

            // Иногда добавляем возвраты для истории
            if (rand(1, 5) === 1) {
                Transaction::create([
                    'equipment_id' => $equipment->id,
                    'type' => TransactionTypeEnum::RETURN,
                    'from_user_id' => $users->random()->id,
                    'to_user_id' => null,
                    'occurred_at' => Carbon::today()->subDays(rand(40, 60)),
                    'comment' => 'Возврат после объекта',
                    'created_by' => $admin->id,
                ]);
            }
        }
    }
}
