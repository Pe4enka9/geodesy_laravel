<?php

namespace App\Livewire\Calibrations;

use App\Models\Calibrations\Calibration;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('calibration-updated')]
    public function refreshList(): void
    {
    }

    public function delete(Calibration $calibration): void
    {
        $calibration->delete();
        $this->dispatch('calibration-updated');
    }

    public function render(): View
    {
        $calibrations = Calibration::latest()->get();

        $statuses = [
            'expired' => 'error',
            'active' => 'success',
            'voided' => 'voided',
        ];

        return view('livewire.calibrations.index', [
            'calibrations' => $calibrations,
            'statuses' => $statuses,
        ]);
    }
}
