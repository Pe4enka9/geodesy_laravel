@extends('theme')
@section('title', 'Типы оборудования')
@section('content')
    <div class="tab">
        <h2 class="tab__title">Типы оборудования</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['placeholder' => 'Поиск по названию, коду...', 'btn' => 'Добавить тип'])

            <div class="cards">
                @foreach($types as $type)
                    <div class="card">
                        <div class="card__header">
                            <div class="card__img-wrapper card__img-wrapper--purple">
                                <img src="{{ asset('icons/types-purple.svg') }}" alt="" class="card__img">
                            </div>

                            <div class="card__content">
                                <h3 class="card__title">{{ $type->name }}</h3>
                                <div class="card__code">Код: {{ $type->code }}</div>
                            </div>

                            @include('components.actions')
                        </div>

                        <div class="card__body">
                            <div class="card__description">{{ $type->description }}</div>

                            <div class="card__updated-at card__updated-at--light">
                                Обновлено: {{ $type->updated_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
