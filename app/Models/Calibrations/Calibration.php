<?php

namespace App\Models\Calibrations;

use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
        'status' => CalibrationStatusEnum::class,
    ];
}
