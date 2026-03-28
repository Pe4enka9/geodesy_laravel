<?php

namespace App\Http\Requests\Equipment;

use App\Models\EquipmentModel;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

#[MapName(SnakeCaseMapper::class)]
class UpdateDto extends Data
{
    public function __construct(
        #[Exists(EquipmentType::class, 'id')]
        public int     $equipmentType,
        #[Unique(Equipment::class, 'inventory_number', ignore: new RouteParameterReference('equipment', 'id'))]
        public string  $inventoryNumber,
        public ?string $serialNumber,
        #[Exists(EquipmentModel::class, 'id')]
        public ?int    $equipmentModel,
    )
    {
    }
}
