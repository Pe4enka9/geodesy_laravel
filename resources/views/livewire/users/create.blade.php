@use(App\Models\Users\Enums\UserPositionEnum, Position)
@use(App\Models\Users\Enums\UserRoleEnum, Role)

<x-forms.modal-create-form title="Добавить пользователя">
    <div class="input-wrapper">
        <label for="last_name">Фамилия</label>
        <input type="text" @class(['invalid' => $errors->has('last_name')]) placeholder="Иванов"
               wire:model="last_name">

        @error('last_name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="first_name">Имя</label>
        <input type="text" @class(['invalid' => $errors->has('first_name')]) placeholder="Иван"
               wire:model="first_name">

        @error('first_name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="login">Логин</label>
        <input type="text" @class(['invalid' => $errors->has('login')]) placeholder="ivanov" wire:model="login">

        @error('login')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="password">Пароль</label>
        <input type="password" @class(['invalid' => $errors->has('password')]) placeholder="Минимум 6 символов"
               wire:model="password">

        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="password_confirmation">Повторите пароль</label>
        <input type="password"
               @class(['invalid' => $errors->has('password_confirmation')]) placeholder="Минимум 6 символов"
               wire:model="password_confirmation">
    </div>

    <div class="input-wrapper">
        <label for="position">Должность</label>
        <select @class(['invalid' => $errors->has('position')]) wire:model="position">
            <option value="">Не указана</option>
            @foreach(Position::cases() as $position)
                <option value="{{ $position }}">{{ $position->label() }}</option>
            @endforeach
        </select>

        @error('position')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="role">Роль</label>
        <select @class(['invalid' => $errors->has('role')]) wire:model="role">
            @foreach(Role::cases() as $role)
                <option value="{{ $role }}">{{ $role->label() }}</option>
            @endforeach
        </select>

        @error('role')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</x-forms.modal-create-form>
