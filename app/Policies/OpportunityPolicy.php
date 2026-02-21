<?php

namespace App\Policies;

use App\Models\Opportunity;
use App\Models\User;

class OpportunityPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Opportunity $opportunity): bool
    {
        return $user->isAdmin() || $opportunity->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Opportunity $opportunity): bool
    {
        return $this->view($user, $opportunity);
    }

    public function delete(User $user, Opportunity $opportunity): bool
    {
        return $this->view($user, $opportunity);
    }

    public function restore(User $user, Opportunity $opportunity): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Opportunity $opportunity): bool
    {
        return $user->isAdmin();
    }
}
