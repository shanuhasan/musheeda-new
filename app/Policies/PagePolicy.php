<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }

    public function view(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }

    public function update(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }

    public function restore(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }

    public function forceDelete(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('manage_pages');
    }
}
