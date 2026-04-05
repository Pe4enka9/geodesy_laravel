<x-forms.modal-create-form title="Добавить модель">
    <div class="input-wrapper">
        <label for="name">Название</label>
        <input type="text" @class(['invalid' => $errors->has('name')]) placeholder="Например: Leica TS16"
               wire:model="name">

        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</x-forms.modal-create-form>
