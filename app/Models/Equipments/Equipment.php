<?php

namespace App\Models\Equipments;

use App\Models\Calibrations\Calibration;
use App\Models\EquipmentModel;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\EquipmentType;
use App\Models\TransferRequests\TransferRequest;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded(['id'])]
class Equipment extends Model
{
    protected $table = 'equipments';

    protected $casts = [
        'status' => EquipmentStatusEnum::class,
    ];

    public function model(): BelongsTo
    {
        return $this->belongsTo(EquipmentModel::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function calibrations(): HasMany
    {
        return $this->hasMany(Calibration::class);
    }

    public function currentHolder(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCurrentHolder(User $user): bool
    {
        return $this->current_holder_id === $user->id;
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(TransferRequest::class);
    }
}
