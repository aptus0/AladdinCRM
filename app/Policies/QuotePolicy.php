<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;

class QuotePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Quote $quote): bool
    {
        return $user->isAdmin() || $quote->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Quote $quote): bool
    {
        return $this->view($user, $quote);
    }

    public function delete(User $user, Quote $quote): bool
    {
        return $this->view($user, $quote);
    }

    public function restore(User $user, Quote $quote): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Quote $quote): bool
    {
        return $user->isAdmin();
    }
}
