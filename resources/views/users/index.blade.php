@use(App\Models\Users\Enums\UserRoleEnum, Role)
@extends('theme')
@section('title', 'Персонал')
@section('content')
    <livewire:users.create/>
    <livewire:users.edit/>

    <div class="tab">
        <h2 class="tab__title">Персонал</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Role::cases(), 'placeholder' => 'Поиск по ФИО, логину...'])
            <livewire:users.index/>
        </div>
    </div>
@endsection
