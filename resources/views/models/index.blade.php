@extends('theme')
@section('title', 'Модели оборудования')
@section('content')
    <div class="tab">
        <h2 class="tab__title">Модели оборудования</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['placeholder' => 'Поиск по названию...', 'btn' => 'Добавить модель'])

            <div class="cards">
                @foreach($models as $model)
                    <div class="card">
                        <div class="card__header">
                            <div class="card__img-wrapper">
                                <img src="{{ asset('icons/models-primary.svg') }}" alt="" class="card__img">
                            </div>

                            <div class="card__content">
                                <h3 class="card__title">{{ $model->name }}</h3>
                                <div class="card__updated-at">Обновлено: {{ $model->updated_at->format('d.m.Y') }}</div>
                            </div>

                            @include('components.actions')
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
