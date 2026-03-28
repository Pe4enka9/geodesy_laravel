<?php

namespace Database\Seeders;

use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\TransferRequest;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class TransferRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Создадим 2-3 активные заявки на передачу
        $employees = User::where('role', 'employee')->get();
        $equipmentWithHolder = Equipment::whereNotNull('current_holder_id')->get();

        if ($equipmentWithHolder->count() < 2 || $employees->count() < 2) return;

        for ($i = 0; $i < 2; $i++) {
            $equipment = $equipmentWithHolder->random();
            $sender = User::find($equipment->current_holder_id);
            $receiver = $employees->where('id', '!=', $sender->id)->random();

            TransferRequest::create([
                'equipment_id' => $equipment->id,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'status' => 'pending',
                'comment' => 'Передача инструмента на смежный участок',
            ]);
        }
    }
}
