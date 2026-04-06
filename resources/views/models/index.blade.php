@extends('theme')
@section('title', 'Модели оборудования')
@section('content')
    <livewire:models.create/>
    <livewire:models.edit/>

    <x-tab title="Модели оборудования">
        <livewire:models.index/>
    </x-tab>
@endsection
