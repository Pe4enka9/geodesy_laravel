<?php

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\TransferRequest;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Главная')]
class extends Component {
    public int $allEquipments;
    public int $activeEquipments;
    public int $inactiveEquipments;
    public int $expiredEquipments;
    public Collection $transfers;

    public function mount(): void
    {
        $this->allEquipments = Equipment::count();
        $this->activeEquipments = Equipment::where('status', EquipmentStatusEnum::ACTIVE)->count();
        $this->inactiveEquipments = Equipment::where('status', EquipmentStatusEnum::INACTIVE)->count();
        $this->expiredEquipments = Equipment::where('status', EquipmentStatusEnum::CALIBRATION_EXPIRED)->count();
        $this->transfers = TransferRequest::with(['equipment', 'sender', 'receiver'])->latest()->limit(5)->get();
    }
};
?>

<x-tab title="Главная">
    <x-tab-content>
        <div class="dashboard">
            <div class="dashboard__cards">
                <x-cards.dashboard
                    title="Всего оборудования"
                    :count="$this->allEquipments"
                    style="blue"
                    icon="box"
                />

                <x-cards.dashboard
                    title="В работе"
                    :count="$this->activeEquipments"
                    style="green"
                    icon="success"
                />

                <x-cards.dashboard
                    title="На складе"
                    :count="$this->inactiveEquipments"
                    style="purple"
                    icon="box"
                />

                <x-cards.dashboard
                    title="Просрочена поверка"
                    :count="$this->expiredEquipments"
                    style="red"
                    icon="danger"
                />
            </div>

            <div class="dashboard__transfers">
                <div class="dashboard__transfers-header">
                    <div class="dashboard__transfers-title-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" class="dashboard__transfers-icon" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 6v6l4 2"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>

                        <div class="dashboard__transfers-title">Последние передачи</div>
                    </div>

                    <a href="{{ route('transfers') }}" class="dashboard__transfers-link">
                        Все передачи
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" class="dashboard__transfers-link-icon" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="dashboard__transfers-cards">
                    @php /** @var TransferRequest $transfer */ @endphp

                    @foreach($this->transfers as $transfer)
                        <x-cards.dashboard-transfers
                            :equipment-name="$transfer->equipment->inventory_number"
                            :sender="$transfer->sender?->getInitials()"
                            :receiver="$transfer->receiver?->getInitials()"
                            :updated-at="$transfer->updated_at->format('d.m.Y H:i')"
                            :status="$transfer->status"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </x-tab-content>
</x-tab>
