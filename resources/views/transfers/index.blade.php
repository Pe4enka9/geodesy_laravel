@use(App\Models\TransferRequests\Enums\TransferRequestStatusEnum, Status)
@extends('theme')
@section('title', 'Передачи оборудования')
@section('content')
    <div class="tab">
        <h2 class="tab__title">Передачи оборудования</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по оборудованию...', 'hasBtn' => false])
            <livewire:transfers.index/>
        </div>
    </div>
@endsection
