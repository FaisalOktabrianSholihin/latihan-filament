<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Budidaya;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudidayaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Budidaya');
    }

    public function view(AuthUser $authUser, Budidaya $budidaya): bool
    {
        return $authUser->can('View:Budidaya');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Budidaya');
    }

    public function update(AuthUser $authUser, Budidaya $budidaya): bool
    {
        return $authUser->can('Update:Budidaya');
    }

    public function delete(AuthUser $authUser, Budidaya $budidaya): bool
    {
        return $authUser->can('Delete:Budidaya');
    }

    public function restore(AuthUser $authUser, Budidaya $budidaya): bool
    {
        return $authUser->can('Restore:Budidaya');
    }

    public function forceDelete(AuthUser $authUser, Budidaya $budidaya): bool
    {
        return $authUser->can('ForceDelete:Budidaya');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Budidaya');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Budidaya');
    }

    public function replicate(AuthUser $authUser, Budidaya $budidaya): bool
    {
        return $authUser->can('Replicate:Budidaya');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Budidaya');
    }

}