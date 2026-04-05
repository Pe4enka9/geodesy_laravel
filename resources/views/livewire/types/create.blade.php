<x-forms.modal-create-form title="Добавить тип">
    <div class="input-wrapper">
        <label for="name">Название</label>
        <input type="text" @class(['invalid' => $errors->has('name')]) placeholder="Например: Тахеометр"
               wire:model="name">

        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="code">Код</label>
        <input type="text" @class(['invalid' => $errors->has('code')]) placeholder="Например: TAH" wire:model="code">

        @error('code')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="description">Описание</label>
        <textarea @class(['invalid' => $errors->has('description')]) placeholder="Необязательное описание"
                  wire:model="description"></textarea>

        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</x-forms.modal-create-form>
