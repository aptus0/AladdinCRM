<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Contact $contact): bool
    {
        return $user->isAdmin()
            || $contact->created_by === $user->id
            || $contact->company?->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Contact $contact): bool
    {
        return $this->view($user, $contact);
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $this->view($user, $contact);
    }

    public function restore(User $user, Contact $contact): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Contact $contact): bool
    {
        return $user->isAdmin();
    }
}
