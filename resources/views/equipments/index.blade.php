@extends('theme')
@section('title', 'Оборудование')
@section('content')
    <livewire:equipments.create/>
    <livewire:equipments.edit/>

    <x-tab title="Оборудование">
        <livewire:equipments.index/>
    </x-tab>
@endsection
