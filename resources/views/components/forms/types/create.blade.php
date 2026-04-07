<x-forms.modal-create-form title="Добавить модель">
    <x-forms.input
        label="Название"
        type="text"
        id="create_name"
        name="form.name"
        placeholder="Например: Тахеометр"
        required
    />

    <x-forms.input
        label="Код"
        type="text"
        id="create_code"
        name="form.code"
        placeholder="Например: TAH"
        required
    />

    <x-forms.textarea
        label="Описание"
        id="create_description"
        name="form.description"
        placeholder="Необязательное описание"
    />
</x-forms.modal-create-form>
