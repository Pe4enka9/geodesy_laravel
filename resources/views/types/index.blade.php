@extends('theme')
@section('title', 'Типы оборудования')
@section('content')
    <livewire:types.create/>
    <livewire:types.edit/>

    <div class="tab">
        <h2 class="tab__title">Типы оборудования</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['placeholder' => 'Поиск по названию, коду...', 'btn' => 'Добавить тип'])
            <livewire:types.index/>
        </div>
    </div>
@endsection
