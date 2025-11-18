<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MstFasemonitor;
use Illuminate\Auth\Access\HandlesAuthorization;

class MstFasemonitorPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MstFasemonitor');
    }

    public function view(AuthUser $authUser, MstFasemonitor $mstFasemonitor): bool
    {
        return $authUser->can('View:MstFasemonitor');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MstFasemonitor');
    }

    public function update(AuthUser $authUser, MstFasemonitor $mstFasemonitor): bool
    {
        return $authUser->can('Update:MstFasemonitor');
    }

    public function delete(AuthUser $authUser, MstFasemonitor $mstFasemonitor): bool
    {
        return $authUser->can('Delete:MstFasemonitor');
    }

    public function restore(AuthUser $authUser, MstFasemonitor $mstFasemonitor): bool
    {
        return $authUser->can('Restore:MstFasemonitor');
    }

    public function forceDelete(AuthUser $authUser, MstFasemonitor $mstFasemonitor): bool
    {
        return $authUser->can('ForceDelete:MstFasemonitor');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MstFasemonitor');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MstFasemonitor');
    }

    public function replicate(AuthUser $authUser, MstFasemonitor $mstFasemonitor): bool
    {
        return $authUser->can('Replicate:MstFasemonitor');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MstFasemonitor');
    }

}