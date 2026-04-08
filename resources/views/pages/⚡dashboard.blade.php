<?php

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\TransferRequest;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Дашборд')]
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

<x-tab title="Дашборд">
    <x-tab-content>
        <div class="dashboard">
            <div class="dashboard__title-wrapper">
                <h2 class="dashboard__title">Добро пожаловать, {{ auth()->user()->first_name }}!</h2>
                <p class="dashboard__subtitle">Обзор состояния геодезического оборудования</p>
            </div>

            <div class="dashboard__cards">
                <x-cards.dashboard
                    title="Всего оборудования"
                    :count="$this->allEquipments"
                    :icon="asset('icons/dashboard-equipment.svg')"
                    style="blue"
                />

                <x-cards.dashboard
                    title="В работе"
                    :count="$this->activeEquipments"
                    :icon="asset('icons/success.svg')"
                    style="green"
                />

                <x-cards.dashboard
                    title="На складе"
                    :count="$this->inactiveEquipments"
                    :icon="asset('icons/dashboard-equipment-purple.svg')"
                    style="purple"
                />

                <x-cards.dashboard
                    title="Просрочена поверка"
                    :count="$this->expiredEquipments"
                    :icon="asset('icons/danger.svg')"
                    style="red"
                />
            </div>

            <div class="dashboard__transfers">
                <div class="dashboard__transfers-header">
                    <div class="dashboard__transfers-title-wrapper">
                        <img src="{{ asset('icons/cloak.svg') }}" alt="" class="dashboard__transfers-icon">
                        <div class="dashboard__transfers-title">Последние передачи</div>
                    </div>

                    <a href="{{ route('transfers') }}" class="dashboard__transfers-link">
                        Все передачи
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#0d9488" class="dashboard__transfers-link-icon" stroke-width="2"
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
