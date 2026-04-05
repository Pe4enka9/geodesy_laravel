@extends('theme')
@section('title', 'Модели оборудования')
@section('content')
    <livewire:models.create/>
    <livewire:models.edit/>

    <div class="tab">
        <h2 class="tab__title">Модели оборудования</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['placeholder' => 'Поиск по названию...', 'btn' => 'Добавить модель'])
            <livewire:models.index/>
        </div>
    </div>
@endsection
