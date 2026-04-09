<?php

namespace Database\Seeders;

use App\Models\EquipmentModel;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $types = EquipmentType::all();
        $models = EquipmentModel::all();
        $holders = User::where('role', UserRoleEnum::EMPLOYEE)->get();
        $statuses = EquipmentStatusEnum::cases();

        $equipments = [
            ['inventory_number' => 'TACHEO-001', 'serial_number' => 'SN-964122'],
            ['inventory_number' => 'TACHEO-002', 'serial_number' => 'SN-816492'],
            ['inventory_number' => 'TACHEO-003', 'serial_number' => 'SN-488467'],
            ['inventory_number' => 'GNSS-001', 'serial_number' => 'SN-269719'],
            ['inventory_number' => 'GNSS-002', 'serial_number' => 'SN-162865'],
            ['inventory_number' => 'LEVEL_OPT-001', 'serial_number' => 'SN-698598'],
            ['inventory_number' => 'LEVEL_OPT-002', 'serial_number' => 'SN-464486'],
            ['inventory_number' => 'LEVEL_OPT-003', 'serial_number' => 'SN-462234'],
            ['inventory_number' => 'LEVEL_OPT-004', 'serial_number' => 'SN-648986'],
            ['inventory_number' => 'DISTO-001', 'serial_number' => 'SN-719475'],
            ['inventory_number' => 'DISTO-002', 'serial_number' => 'SN-140440'],
            ['inventory_number' => 'DISTO-003', 'serial_number' => 'SN-926613'],
            ['inventory_number' => 'DISTO-004', 'serial_number' => 'SN-314492'],
            ['inventory_number' => 'DISTO-005', 'serial_number' => 'SN-677760'],
            ['inventory_number' => 'TRIPOD_ALU-001', 'serial_number' => 'SN-185850'],
            ['inventory_number' => 'TRIPOD_ALU-002', 'serial_number' => 'SN-180060'],
            ['inventory_number' => 'TRIPOD_ALU-003', 'serial_number' => 'SN-426093'],
            ['inventory_number' => 'TRIPOD_ALU-004', 'serial_number' => 'SN-570121'],
            ['inventory_number' => 'TRIPOD_ALU-005', 'serial_number' => 'SN-192532'],
            ['inventory_number' => 'TRIPOD_ALU-006', 'serial_number' => 'SN-537583'],
            ['inventory_number' => 'POLE_REF-001', 'serial_number' => 'SN-212323'],
            ['inventory_number' => 'POLE_REF-002', 'serial_number' => 'SN-138864'],
            ['inventory_number' => 'POLE_REF-003', 'serial_number' => 'SN-616564'],
            ['inventory_number' => 'POLE_REF-004', 'serial_number' => 'SN-591731'],
            ['inventory_number' => 'POLE_REF-005', 'serial_number' => 'SN-719472'],
            ['inventory_number' => 'POLE_REF-006', 'serial_number' => 'SN-686090'],
        ];

        foreach ($equipments as $data) {
            $modelId = rand(1, 100) <= 30 ? null : $models->random()->id;
            $holderId = null;
            $serialNumber = rand(1, 100) <= 10 ? null : $data['serial_number'];
            $status = $statuses[array_rand($statuses)];

            if ($status === EquipmentStatusEnum::ACTIVE) {
                $holderId = $holders->random()->id;
            }

            Equipment::create([
                'type_id' => $types->random()->id,
                'inventory_number' => $data['inventory_number'],
                'serial_number' => $serialNumber,
                'model_id' => $modelId,
                'status' => $status,
                'current_holder_id' => $holderId,
            ]);
        }
    }
}
