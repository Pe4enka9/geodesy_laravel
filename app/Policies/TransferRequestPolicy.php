<?php

namespace App\Policies;

use App\Models\TransferRequests\TransferRequest;
use App\Models\Users\User;

class TransferRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TransferRequest $transfer): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, TransferRequest $transfer): bool
    {
        return false;
    }

    public function delete(User $user, TransferRequest $transfer): bool
    {
        return false;
    }

    public function restore(User $user, TransferRequest $transfer): bool
    {
        return false;
    }

    public function forceDelete(User $user, TransferRequest $transfer): bool
    {
        return false;
    }

    public function accept(User $user, TransferRequest $transfer): bool
    {
        return $transfer->isReceiver() && $transfer->isPending();
    }

    public function reject(User $user, TransferRequest $transfer): bool
    {
        return $transfer->isReceiver() && $transfer->isPending();
    }

    public function cancel(User $user, TransferRequest $transfer): bool
    {
        return $transfer->isSender() && $transfer->isPending();
    }
}
