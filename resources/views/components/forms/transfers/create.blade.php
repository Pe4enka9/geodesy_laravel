<x-forms.modal-create-form title="Передача оборудования" custom-event="create-transfer">
    <div class="input-wrapper input-wrapper--equipment">
        <label>Оборудование</label>
        <div>{{ $equipment?->inventory_number }}</div>
        <input type="hidden" wire:model="form.equipmentId">
    </div>

    <x-forms.select
        label="Получатель"
        id="create_user"
        name="form.user"
        placeholder="Выберите получателя"
        hidden-placeholder
        required
    >
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->getFullName() }}</option>
        @endforeach
    </x-forms.select>

    <x-forms.textarea
        label="Комментарий"
        id="create_comment"
        name="form.comment"
        placeholder="Необязательный комментарий к передаче"
    />
</x-forms.modal-create-form>
