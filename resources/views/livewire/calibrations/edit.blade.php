<x-forms.modal-edit-form title="Редактировать поверку">
    <div class="input-wrapper">
        <label for="equipment">Оборудование</label>
        <select @class(['invalid' => $errors->has('equipment')]) wire:model="equipment">
            <option value="" hidden>Выберите оборудование</option>
            @foreach($equipments as $equipment)
                <option value="{{ $equipment->id }}">{{ $equipment->inventory_number }}</option>
            @endforeach
        </select>

        @error('equipment')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="certificate_number">Номер сертификата</label>
        <input type="text"
               @class(['invalid' => $errors->has('certificate_number')]) placeholder="Например: СЕРТ-2024-001"
               wire:model="certificate_number">

        @error('certificate_number')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="verification_url">Ссылка на сертификат</label>
        <input type="url" @class(['invalid' => $errors->has('verification_url')]) placeholder="https://..."
               wire:model="verification_url">

        @error('verification_url')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="issued_at">Дата получения</label>
        <input type="date" @class(['invalid' => $errors->has('issued_at')]) wire:model="issued_at">

        @error('issued_at')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="expires_at">Действует до</label>
        <input type="date" @class(['invalid' => $errors->has('expires_at')]) wire:model="expires_at">

        @error('expires_at')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</x-forms.modal-edit-form>
