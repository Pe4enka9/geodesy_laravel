@extends('theme')
@section('title', 'Типы оборудования')
@section('content')
    <livewire:types.create/>
    <livewire:types.edit/>

    <x-tab title="Типы оборудования">
        <livewire:types.index/>
    </x-tab>
@endsection
