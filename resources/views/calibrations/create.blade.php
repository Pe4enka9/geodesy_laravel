@extends('theme')
@section('title', 'Добавить поверку')
@section('content')
    <form action="{{ route('calibrations.store') }}" method="post">
        @csrf
        <h1>Добавить поверку</h1>

        @if($equipments->isNotEmpty())
            <div>
                <label for="equipment">Оборудование</label>
                <select name="equipment" id="equipment">
                    <option value="" hidden>Выберите оборудование</option>
                    @foreach($equipments as $equipment)
                        <option
                            value="{{ $equipment->id }}"
                            @selected(old('equipment') == $equipment->id)
                        >
                            {{ $equipment->inventory_number }}
                        </option>
                    @endforeach
                </select>

                @error('equipment')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="certificate_number">Номер сертификата</label>
                <input type="text" name="certificate_number" id="certificate_number" placeholder="Номер сертификата"
                       value="{{ old('certificate_number') }}">

                @error('certificate_number')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="verification_url">Ссылка на поверку</label>
                <input type="url" name="verification_url" id="verification_url" placeholder="Ссылка на поверку"
                       value="{{ old('verification_url') }}">

                @error('verification_url')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="issued_at">Дата получения</label>
                <input type="date" name="issued_at" id="issued_at" value="{{ old('issued_at') }}">

                @error('issued_at')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="expires_at">Дата окончания</label>
                <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}">

                @error('expires_at')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Добавить</button>
        @else
            <h3>Нет оборудования без поверок</h3>
            <a href="{{ route('equipments.create') }}">Добавить оборудование</a>
        @endif
    </form>
@endsection
