<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Kriteria;
use Illuminate\Auth\Access\HandlesAuthorization;

class KriteriaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Kriteria');
    }

    public function view(AuthUser $authUser, Kriteria $kriteria): bool
    {
        return $authUser->can('View:Kriteria');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Kriteria');
    }

    public function update(AuthUser $authUser, Kriteria $kriteria): bool
    {
        return $authUser->can('Update:Kriteria');
    }

    public function delete(AuthUser $authUser, Kriteria $kriteria): bool
    {
        return $authUser->can('Delete:Kriteria');
    }

    public function restore(AuthUser $authUser, Kriteria $kriteria): bool
    {
        return $authUser->can('Restore:Kriteria');
    }

    public function forceDelete(AuthUser $authUser, Kriteria $kriteria): bool
    {
        return $authUser->can('ForceDelete:Kriteria');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Kriteria');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Kriteria');
    }

    public function replicate(AuthUser $authUser, Kriteria $kriteria): bool
    {
        return $authUser->can('Replicate:Kriteria');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Kriteria');
    }

}