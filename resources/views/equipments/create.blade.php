@extends('theme')
@section('title', 'Добавить оборудование')
@section('content')
    <form action="{{ route('equipments.store') }}" method="post">
        @csrf
        <h1>Добавить оборудование</h1>

        <div>
            <label for="equipment_type">Тип</label>
            <select name="equipment_type" id="equipment_type">
                <option value="" hidden>Выберите тип</option>
                @foreach($types as $type)
                    <option
                        value="{{ $type->id }}"
                        @selected(old('equipment_type') == $type->id)
                    >
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>

            @error('equipment_type')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="inventory_number">Инвентарный номер</label>
            <input type="text" name="inventory_number" id="inventory_number" placeholder="Инвентарный номер"
                   value="{{ old('inventory_number') }}">

            @error('inventory_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="serial_number">Серийный номер</label>
            <input type="text" name="serial_number" id="serial_number" placeholder="Серийный номер"
                   value="{{ old('serial_number') }}">

            @error('serial_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="model">Модель</label>
            <select name="equipment_model" id="equipment_model">
                <option value="">Выберите модель</option>
                @foreach($models as $model)
                    <option
                        value="{{ $model->id }}"
                        @selected(old('equipment_model') == $model->id)
                    >
                        {{ $model->name }}
                    </option>
                @endforeach
            </select>

            @error('equipment_model')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="button" id="add">Добавить поверку</button>

        <div style="display:none;">
            <h2>Поверка</h2>
            <input type="hidden" name="has_calibration" id="has_calibration" value="0">

            <div>
                <label for="certificate_number">Номер свидетельства</label>
                <input type="text" name="certificate_number" id="certificate_number" placeholder="Номер свидетельства"
                       value="{{ old('certificate_number') }}">

                @error('certificate_number')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="verification_url">Ссылка на реестр</label>
                <input type="url" name="verification_url" id="verification_url" placeholder="Ссылка на реестр"
                       value="{{ old('verification_url') }}">

                @error('verification_url')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="issued_at">Дата выдачи</label>
                <input type="date" name="issued_at" id="issued_at" value="{{ old('issued_at') }}">

                @error('issued_at')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="expires_at">Дата истечения срока действия</label>
                <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}">

                @error('expires_at')
                <div>{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit">Добавить</button>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('add').addEventListener('click', function () {
            const elem = this.nextElementSibling;
            const hasCalibration = document.getElementById('has_calibration');

            if (elem.style.display === 'none') {
                elem.style.display = 'block';
                this.textContent = 'Удалить поверку';
                hasCalibration.value = '1';
            } else {
                elem.style.display = 'none';
                this.textContent = 'Добавить поверку';
                hasCalibration.value = '0';
            }
        });
    </script>
@endpush
