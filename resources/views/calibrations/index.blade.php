@extends('theme')
@section('title', 'Поверки')
@section('content')
    <livewire:calibrations.create/>
    <livewire:calibrations.edit/>

    <x-tab title="Поверки">
        <livewire:calibrations.index/>
    </x-tab>
@endsection
