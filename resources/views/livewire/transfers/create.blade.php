<x-forms.modal-create-form title="Передача оборудования" custom-event="create-transfer">
    <div class="input-wrapper input-wrapper--equipment">
        <label>Оборудование</label>
        <div>{{ $equipment?->inventory_number }}</div>
        <input type="hidden" wire:model="equipmentId">
    </div>

    <div class="input-wrapper">
        <label>Получатель</label>
        <select @class(['invalid' => $errors->has('user')]) wire:model="user">
            <option value="" hidden>Выберите получателя</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->getFullName() }}</option>
            @endforeach
        </select>

        @error('user')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label>Комментарий</label>
        <textarea @class(['invalid' => $errors->has('comment')]) placeholder="Необязательный комментарий к передаче"
                  wire:model="comment"></textarea>

        @error('comment')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</x-forms.modal-create-form>
