@extends('theme')
@section('title', 'Изменить поверку')
@section('content')
    <form action="{{ route('calibrations.update', $calibration) }}" method="post">
        @csrf
        @method('PATCH')
        <h1>Изменить поверку</h1>

        <div>
            <label for="equipment">Оборудование</label>
            <select name="equipment" id="equipment" disabled>
                <option>{{ $calibration->equipment->inventory_number }}</option>
            </select>
        </div>

        <div>
            <label for="certificate_number">Номер сертификата</label>
            <input type="text" name="certificate_number" id="certificate_number" placeholder="Номер сертификата"
                   value="{{ old('certificate_number', $calibration->certificate_number) }}">

            @error('certificate_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="verification_url">Ссылка на поверку</label>
            <input type="url" name="verification_url" id="verification_url" placeholder="Ссылка на поверку"
                   value="{{ old('verification_url', $calibration->verification_url) }}">

            @error('verification_url')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="issued_at">Дата получения</label>
            <input type="date" name="issued_at" id="issued_at"
                   value="{{ old('issued_at', $calibration->issued_at->format('Y-m-d')) }}">

            @error('issued_at')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="expires_at">Дата окончания</label>
            <input type="date" name="expires_at" id="expires_at"
                   value="{{ old('expires_at', $calibration->expires_at->format('Y-m-d')) }}">

            @error('expires_at')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Изменить</button>
    </form>
@endsection
