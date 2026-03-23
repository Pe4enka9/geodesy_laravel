<?php

namespace App\Models;

use App\Enums\Equipments\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    protected $guarded = ['id'];
    protected $table = 'equipments';

    protected $casts = [
        'status' => Status::class,
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
