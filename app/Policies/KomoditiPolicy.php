<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Komoditi;
use Illuminate\Auth\Access\HandlesAuthorization;

class KomoditiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Komoditi');
    }

    public function view(AuthUser $authUser, Komoditi $komoditi): bool
    {
        return $authUser->can('View:Komoditi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Komoditi');
    }

    public function update(AuthUser $authUser, Komoditi $komoditi): bool
    {
        return $authUser->can('Update:Komoditi');
    }

    public function delete(AuthUser $authUser, Komoditi $komoditi): bool
    {
        return $authUser->can('Delete:Komoditi');
    }

    public function restore(AuthUser $authUser, Komoditi $komoditi): bool
    {
        return $authUser->can('Restore:Komoditi');
    }

    public function forceDelete(AuthUser $authUser, Komoditi $komoditi): bool
    {
        return $authUser->can('ForceDelete:Komoditi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Komoditi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Komoditi');
    }

    public function replicate(AuthUser $authUser, Komoditi $komoditi): bool
    {
        return $authUser->can('Replicate:Komoditi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Komoditi');
    }

}