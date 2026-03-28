<?php

namespace App\Services\User\Actions;

use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public function __invoke(User $user, string $password): void
    {
        DB::table('sessions')->where('user_id', $user->id)->delete();
        $user->update(['password' => Hash::make($password)]);
    }
}
