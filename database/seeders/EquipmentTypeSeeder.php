<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Тахеометр электронный', 'code' => 'TACHEO'],
            ['name' => 'Нивелир оптический', 'code' => 'LEVEL_OPT'],
            ['name' => 'GPS-приемник (GNSS)', 'code' => 'GNSS'],
            ['name' => 'Лазерный дальномер', 'code' => 'DISTO'],
            ['name' => 'Штатив алюминиевый', 'code' => 'TRIPOD_ALU'],
            ['name' => 'Веха с отражателем', 'code' => 'POLE_REF'],
        ];

        foreach ($types as $type) {
            EquipmentType::create($type);
        }
    }
}
