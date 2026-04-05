@use(App\Models\Calibrations\Enums\CalibrationStatusEnum, Status)
@extends('theme')
@section('title', 'Поверки')
@section('content')
    <livewire:calibrations.create/>
    <livewire:calibrations.edit/>

    <div class="tab">
        <h2 class="tab__title">Поверки</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по номеру сертификата...'])
            <livewire:calibrations.index/>
        </div>
    </div>
@endsection
