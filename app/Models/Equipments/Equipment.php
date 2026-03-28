<?php

namespace App\Models\Equipments;

use App\Models\Calibrations\Calibration;
use App\Models\EquipmentModel;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Guarded(['id'])]
class Equipment extends Model
{
    protected $table = 'equipments';

    protected $casts = [
        'status' => EquipmentStatusEnum::class,
    ];

    public function equipmentModel(): BelongsTo
    {
        return $this->belongsTo(EquipmentModel::class);
    }

    public function calibrations(): HasMany
    {
        return $this->hasMany(Calibration::class);
    }

    public function currentHolder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_holder_id');
    }

    public function lastCalibration(): HasOne
    {
        return $this->hasOne(Calibration::class)->latest();
    }
}
