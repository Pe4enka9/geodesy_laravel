@use(App\Models\Equipments\Enums\EquipmentStatusEnum, Status)
@extends('theme')
@section('title', 'Оборудование')
@section('content')
    <livewire:equipments.create/>
    <livewire:equipments.edit/>

    <div class="tab">
        <h2 class="tab__title">Оборудование</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по номеру...'])
            <livewire:equipments.index/>
        </div>
    </div>
@endsection
