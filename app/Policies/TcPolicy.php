<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Tc;
use Illuminate\Auth\Access\HandlesAuthorization;

class TcPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Tc');
    }

    public function view(AuthUser $authUser, Tc $tc): bool
    {
        return $authUser->can('View:Tc');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Tc');
    }

    public function update(AuthUser $authUser, Tc $tc): bool
    {
        return $authUser->can('Update:Tc');
    }

    public function delete(AuthUser $authUser, Tc $tc): bool
    {
        return $authUser->can('Delete:Tc');
    }

    public function restore(AuthUser $authUser, Tc $tc): bool
    {
        return $authUser->can('Restore:Tc');
    }

    public function forceDelete(AuthUser $authUser, Tc $tc): bool
    {
        return $authUser->can('ForceDelete:Tc');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Tc');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Tc');
    }

    public function replicate(AuthUser $authUser, Tc $tc): bool
    {
        return $authUser->can('Replicate:Tc');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Tc');
    }

}