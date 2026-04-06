<?php

namespace App\Livewire\Calibrations;

use App\Models\Calibrations\Calibration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    #[On('calibration-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        Calibration::find($id)->delete();
        $this->dispatch('calibration-updated');
    }

    public function render(): View
    {
        $calibrations = Calibration::when($this->search, function (Builder $query) {
            $query->where('certificate_number', 'like', "%$this->search%");
        })
            ->latest()
            ->get();

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
