<?php

namespace App\Livewire\Forms;

use App\Models\Calibrations\Calibration;
use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CalibrationForm extends Form
{
    public ?int $editId = null;
    #[Validate]
    public int $equipment_id = 0;
    #[Validate]
    public string $certificate_number = '';
    #[Validate]
    public ?string $verification_url = null;
    #[Validate]
    public string $issued_at = '';
    #[Validate]
    public string $expires_at = '';

    protected function rules(): array
    {
        return [
            'equipment_id' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
            'certificate_number' => ['required', 'string'],
            'verification_url' => ['required', 'string', 'url'],
            'issued_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after:issued_at'],
        ];
    }

    private function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    private function setStatus(): CalibrationStatusEnum
    {
        return $this->isExpired() ? CalibrationStatusEnum::EXPIRED : CalibrationStatusEnum::ACTIVE;
    }

    private function setEquipmentStatus(Equipment $equipment): void
    {
        $equipment->update([
            'status' => $this->isExpired() ? EquipmentStatusEnum::CALIBRATION_EXPIRED : EquipmentStatusEnum::INACTIVE,
        ]);
    }

    public function store(): Calibration
    {
        $this->validate();

        $equipment = Equipment::findOrFail($this->equipment_id);
        $this->setEquipmentStatus($equipment);

        return $equipment->calibrations()->create([
            'certificate_number' => $this->certificate_number,
            'verification_url' => $this->verification_url,
            'issued_at' => $this->issued_at,
            'expires_at' => $this->expires_at,
            'status' => $this->setStatus(),
        ]);
    }

    public function update(Calibration $calibration): Calibration
    {
        $this->validate();

        $equipment = Equipment::findOrFail($this->equipment_id);
        $this->setEquipmentStatus($equipment);

        $calibration->update([
            'equipment_id' => $this->equipment_id,
            'certificate_number' => $this->certificate_number,
            'verification_url' => $this->verification_url,
            'issued_at' => $this->issued_at,
            'expires_at' => $this->expires_at,
            'status' => $this->setStatus(),
        ]);

        return $calibration;
    }

    public function setCalibration(Calibration $calibration): void
    {
        $this->editId = $calibration->id;
        $this->equipment_id = $calibration->equipment_id;
        $this->certificate_number = $calibration->certificate_number;
        $this->verification_url = $calibration->verification_url;
        $this->issued_at = $calibration->issued_at->format('Y-m-d');
        $this->expires_at = $calibration->expires_at->format('Y-m-d');
    }
}
