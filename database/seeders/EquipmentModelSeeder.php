<?php

namespace Database\Seeders;

use App\Models\EquipmentModel;
use Illuminate\Database\Seeder;

class EquipmentModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            ['name' => 'Leica TS06'],
            ['name' => 'Trimble R10'],
            ['name' => 'Sokkia C410'],
            ['name' => 'Bosch GLM 50'],
            ['name' => 'Generic A-50'],
            ['name' => 'Rod 2m'],
        ];

        foreach ($models as $model) {
            EquipmentModel::create($model);
        }
    }
}
