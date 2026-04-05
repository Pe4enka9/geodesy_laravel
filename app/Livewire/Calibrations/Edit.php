<?php

namespace App\Livewire\Calibrations;

use App\Models\Calibrations\Calibration;
use App\Models\Equipments\Equipment;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['open-edit' => 'open'];

    public Collection $equipments;

    public Calibration $calibration;

    public int $equipment;
    public string $certificate_number;
    public string $verification_url;
    public string $issued_at;
    public string $expires_at;

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

    public function open(Calibration $item): void
    {
        $this->calibration = $item;
        $this->equipment = $item->equipment_id;
        $this->certificate_number = $item->certificate_number;
        $this->verification_url = $item->verification_url;
        $this->issued_at = $item->issued_at->format('Y-m-d');
        $this->expires_at = $item->expires_at->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate();

        $this->calibration->update([
            'equipment_id' => $this->equipment,
            'certificate_number' => $this->certificate_number,
            'verification_url' => $this->verification_url,
            'issued_at' => $this->issued_at,
            'expires_at' => $this->expires_at,
        ]);

        $this->reset(['equipment', 'certificate_number', 'verification_url', 'issued_at', 'expires_at']);
        $this->dispatch('calibration-updated');
        $this->dispatch('close-edit');
    }

    public function mount(): void
    {
        $this->equipments = Equipment::all();
    }

    public function render(): View
    {
        return view('livewire.calibrations.edit');
    }
}
