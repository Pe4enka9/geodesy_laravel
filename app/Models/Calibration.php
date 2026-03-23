<?php

namespace App\Models;

use App\Enums\Calibrations\Status;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
        'status' => Status::class,
    ];
}
