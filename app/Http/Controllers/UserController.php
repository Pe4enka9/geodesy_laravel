<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateDto;
use App\Http\Requests\User\UpdateDto;
use App\Models\Users\User;
use App\Services\User\Actions\ChangePasswordAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    // Все пользователи
    public function index(): View
    {
        $users = User::exceptMe()->latest()->get();

        return view('users.index', ['users' => $users]);
    }

    // Форма создания пользователя
    public function create(): View
    {
        return view('users.create');
    }

    // Создание пользователя
    public function store(CreateDto $createDto): RedirectResponse
    {
        User::create([
            'name' => $createDto->name,
            'login' => $createDto->login,
            'position' => $createDto->position,
            'role' => $createDto->role,
            'password' => Hash::make($createDto->password),
        ]);

        return redirect()->route('users.index');
    }

    // Форма редактирования пользователя
    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    // Обновления пользователя
    public function update(
        User                 $user,
        UpdateDto            $updateDto,
        ChangePasswordAction $changePasswordAction,
    ): RedirectResponse
    {
        $user->update([
            'name' => $updateDto->name,
            'login' => $updateDto->login,
            'position' => $updateDto->position,
            'role' => $updateDto->role,
        ]);

        if ($updateDto->password) {
            $changePasswordAction($user, $updateDto->password);
        }

        return redirect()->route('users.index');
    }

    // Удаление пользователя
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
