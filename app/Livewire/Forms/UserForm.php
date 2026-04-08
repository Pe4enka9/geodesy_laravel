<?php

namespace App\Livewire\Forms;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?int $editId = null;
    #[Validate]
    public string $last_name = '';
    #[Validate]
    public string $first_name = '';
    #[Validate]
    public string $login = '';
    #[Validate]
    public string $password = '';
    #[Validate]
    public ?UserPositionEnum $position = null;
    #[Validate]
    public UserRoleEnum $role = UserRoleEnum::EMPLOYEE;

    protected function rules(?User $user = null): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'login' => ['required', 'string', Rule::unique(User::class, 'login')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:6'],
            'position' => ['nullable', new Enum(UserPositionEnum::class)],
            'role' => ['required', new Enum(UserRoleEnum::class)],
        ];
    }

    public function store(): User
    {
        $this->validate($this->rules());

        return User::create([
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'login' => $this->login,
            'password' => Hash::make($this->password),
            'position' => $this->position,
            'role' => $this->role,
        ]);
    }

    public function update(User $user): User
    {
        $this->validate($this->rules($user));

        $user->update([
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'login' => $this->login,
            'position' => $this->position,
            'role' => $this->role,
        ]);

        if ($this->password) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            $user->update(['password' => Hash::make($this->password)]);
        }

        return $user;
    }

    public function setUser(User $user): void
    {
        $this->editId = $user->id;
        $this->last_name = $user->last_name;
        $this->first_name = $user->first_name;
        $this->login = $user->login;
        $this->position = $user->position;
        $this->role = $user->role;
    }
}
