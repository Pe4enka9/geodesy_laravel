<?php

namespace App\Livewire\Users;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $last_name;
    public string $first_name;
    public string $login;
    public string $password;
    public string $password_confirmation;
    public ?UserPositionEnum $position = null;
    public UserRoleEnum $role = UserRoleEnum::EMPLOYEE;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'login' => ['required', 'string', Rule::unique(User::class, 'login')],
            'position' => ['nullable', new Enum(UserPositionEnum::class)],
            'role' => ['required', new Enum(UserRoleEnum::class)],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'login' => $this->login,
            'password' => Hash::make($this->password),
            'position' => $this->position,
            'role' => $this->role,
        ]);

        $this->reset();
        $this->dispatch('user-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('livewire.users.create');
    }
}
