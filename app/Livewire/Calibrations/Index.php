<?php

namespace App\Livewire\Calibrations;

use App\Models\Calibrations\Calibration;
use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public ?CalibrationStatusEnum $currentFilter = null;

    #[On('calibration-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        Calibration::find($id)->delete();
        $this->dispatch('calibration-updated');
    }

    public function setFilter(?CalibrationStatusEnum $currentFilter): void
    {
        if (!$currentFilter) {
            $this->currentFilter = null;
            return;
        }

        $this->currentFilter = $currentFilter;
    }

    public function render(): View
    {
        $calibrations = Calibration::with('equipment')
            ->when($this->search, function (Builder $query) {
                $query->where('certificate_number', 'like', "%$this->search%");
            })
            ->when($this->currentFilter, function (Builder $query) {
                $query->where('status', $this->currentFilter);
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
