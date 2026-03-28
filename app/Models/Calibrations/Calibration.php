<?php

namespace App\Models\Calibrations;

use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded(['id'])]
class Calibration extends Model
{
    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
        'status' => CalibrationStatusEnum::class,
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
