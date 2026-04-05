<?php

namespace App\Livewire\Users;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use App\Services\User\Actions\ChangePasswordAction;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['open-edit' => 'open'];

    public User $user;
    public string $last_name;
    public string $first_name;
    public string $login;
    public ?string $password = null;
    public string $password_confirmation;
    public ?UserPositionEnum $position = null;
    public UserRoleEnum $role = UserRoleEnum::EMPLOYEE;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'login' => ['required', 'string', Rule::unique(User::class, 'login')->ignore($this->user)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'position' => ['nullable', new Enum(UserPositionEnum::class)],
            'role' => ['required', new Enum(UserRoleEnum::class)],
        ];
    }

    public function open(User $item): void
    {
        $this->user = $item;
        $this->last_name = $item->last_name;
        $this->first_name = $item->first_name;
        $this->login = $item->login;
        $this->position = $item->position;
        $this->role = $item->role;
    }

    public function save(ChangePasswordAction $changePasswordAction): void
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'login' => $this->login,
            'position' => $this->position,
            'role' => $this->role,
        ]);

        if ($this->password) {
            $changePasswordAction($this->user, $this->password);
        }

        $this->reset();
        $this->dispatch('user-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('livewire.users.edit');
    }
}
