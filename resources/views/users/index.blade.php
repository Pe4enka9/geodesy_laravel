@extends('theme')
@section('title', 'Персонал')
@section('content')
    <livewire:users.create/>
    <livewire:users.edit/>

    <x-tab title="Персонал">
        <livewire:users.index/>
    </x-tab>
@endsection
