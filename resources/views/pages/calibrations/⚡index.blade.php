<?php

use App\Models\Calibrations\Calibration;
use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Поверки')]
class extends Component {
    public array $statuses;
    public string $search = '';
    public ?CalibrationStatusEnum $currentFilter = null;

    #[On('calibration-updated')]
    public function refreshList(): void
    {
    }

    #[Computed]
    public function calibrations(): Collection
    {
        return Calibration::with('equipment')
            ->when($this->search, function (Builder $query) {
                $query->where('certificate_number', 'like', "%$this->search%");
            })
            ->when($this->currentFilter, function (Builder $query) {
                $query->where('status', $this->currentFilter);
            })
            ->latest()
            ->get();
    }

    public function delete(int $id): void
    {
        Calibration::findOrFail($id)->delete();
    }

    public function setFilter(?CalibrationStatusEnum $currentFilter): void
    {
        $this->currentFilter = $currentFilter;
    }

    public function mount(): void
    {
        $this->statuses = [
            'expired' => 'error',
            'active' => 'success',
            'voided' => 'voided',
        ];
    }
};
?>

<x-tab title="Поверки">
    <livewire:calibrations.create/>
    <livewire:calibrations.edit/>

    <x-tab-content>
        <x-tab-actions
            :current-filter="$currentFilter"
            :filters="CalibrationStatusEnum::cases()"
            placeholder="Поиск по номеру сертификата..."
        />

        <x-tables.table
            :headers="['Оборудование', 'Сертификат', 'Получен', 'Действует до', 'Статус']"
            :items="$this->calibrations"
            empty-text="Поверки не найдены"
        >
            @php /** @var Calibration $calibration */ @endphp

            @foreach($this->calibrations as $calibration)
                <x-tables.tr :key="$calibration->id" :mod="$statuses[$calibration->status->value]">
                    <x-tables.td mod="calibrations-equipment">
                        {{ $calibration->equipment->inventory_number }}
                    </x-tables.td>

                    <x-tables.td mod="calibrations-certificate">
                        <div class="table-wrapper__certificate">{{ $calibration->certificate_number }}</div>

                        <a href="{{ $calibration->verification_url }}" target="_blank" class="table-wrapper__link">
                            <img src="{{ asset('icons/link.svg') }}" alt="" class="table-wrapper__link-icon">
                            Ссылка
                        </a>
                    </x-tables.td>
                    <x-tables.td>{{ $calibration->issued_at->format('d.m.Y') }}</x-tables.td>
                    <x-tables.td>{{ $calibration->expires_at->format('d.m.Y') }}</x-tables.td>

                    <x-tables.td>
                        <div class="status status--{{ $statuses[$calibration->status->value] }}">
                            {{ $calibration->status->label() }}
                        </div>
                    </x-tables.td>

                    <x-tables.td>
                        <x-actions :id="$calibration->id" edit delete/>
                    </x-tables.td>
                </x-tables.tr>
            @endforeach
        </x-tables.table>
    </x-tab-content>
</x-tab>
