<?php

namespace App\Livewire\Forms;

use App\Models\Calibrations\Calibration;
use App\Models\Equipments\Equipment;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CalibrationForm extends Form
{
    public ?int $editId = null;
    #[Validate]
    public int $equipment = 0;
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
            'equipment' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
            'certificate_number' => ['required', 'string'],
            'verification_url' => ['required', 'string', 'url'],
            'issued_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after:issued_at'],
        ];
    }

    public function store(): Calibration
    {
        $this->validate();

        return Calibration::create([
            'equipment_id' => $this->equipment,
            'certificate_number' => $this->certificate_number,
            'verification_url' => $this->verification_url,
            'issued_at' => $this->issued_at,
            'expires_at' => $this->expires_at,
        ]);
    }

    public function update(Calibration $calibration): Calibration
    {
        $this->validate();

        $calibration->update([
            'equipment_id' => $this->equipment,
            'certificate_number' => $this->certificate_number,
            'verification_url' => $this->verification_url,
            'issued_at' => $this->issued_at,
            'expires_at' => $this->expires_at,
        ]);

        return $calibration;
    }

    public function setCalibration(Calibration $calibration): void
    {
        $this->editId = $calibration->id;
        $this->equipment = $calibration->equipment_id;
        $this->certificate_number = $calibration->certificate_number;
        $this->verification_url = $calibration->verification_url;
        $this->issued_at = $calibration->issued_at->format('Y-m-d');
        $this->expires_at = $calibration->expires_at->format('Y-m-d');
    }
}
