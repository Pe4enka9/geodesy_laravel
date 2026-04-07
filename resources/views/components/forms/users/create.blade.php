@use(App\Models\Users\Enums\UserPositionEnum,Position)
@use(App\Models\Users\Enums\UserRoleEnum,Role)

<x-forms.modal-create-form title="Добавить пользователя">
    <div class="input-wrapper-row">
        <x-forms.input
            label="Фамилия"
            type="text"
            id="create_last_name"
            name="form.last_name"
            placeholder="Иванов"
            required
        />

        <x-forms.input
            label="Имя"
            type="text"
            id="create_first_name"
            name="form.first_name"
            placeholder="Иван"
            required
        />
    </div>

    <x-forms.input
        label="Логин"
        type="text"
        id="create_login"
        name="form.login"
        placeholder="ivanov"
        required
    />

    <x-forms.input
        label="Пароль"
        type="password"
        id="create_password"
        name="form.password"
        placeholder="Минимум 6 символов"
        required
    />

    <x-forms.select
        label="Должность"
        id="create_position"
        name="form.position"
        placeholder="Не указана"
    >
        @foreach(Position::cases() as $position)
            <option value="{{ $position }}">{{ $position->label() }}</option>
        @endforeach
    </x-forms.select>

    <x-forms.select
        label="Роль"
        id="create_role"
        name="form.role"
        required
    >
        @foreach(Role::cases() as $role)
            <option value="{{ $role }}">{{ $role->label() }}</option>
        @endforeach
    </x-forms.select>
</x-forms.modal-create-form>
