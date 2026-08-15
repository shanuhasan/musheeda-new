<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SettingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }

    public function view(User $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }

    public function update(User $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }

    public function restore(User $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }

    public function forceDelete(User $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('manage_settings');
    }
}
