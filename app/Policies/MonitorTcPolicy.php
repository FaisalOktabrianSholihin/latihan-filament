<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MonitorTc;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitorTcPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MonitorTc');
    }

    public function view(AuthUser $authUser, MonitorTc $monitorTc): bool
    {
        return $authUser->can('View:MonitorTc');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MonitorTc');
    }

    public function update(AuthUser $authUser, MonitorTc $monitorTc): bool
    {
        return $authUser->can('Update:MonitorTc');
    }

    public function delete(AuthUser $authUser, MonitorTc $monitorTc): bool
    {
        return $authUser->can('Delete:MonitorTc');
    }

    public function restore(AuthUser $authUser, MonitorTc $monitorTc): bool
    {
        return $authUser->can('Restore:MonitorTc');
    }

    public function forceDelete(AuthUser $authUser, MonitorTc $monitorTc): bool
    {
        return $authUser->can('ForceDelete:MonitorTc');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MonitorTc');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MonitorTc');
    }

    public function replicate(AuthUser $authUser, MonitorTc $monitorTc): bool
    {
        return $authUser->can('Replicate:MonitorTc');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MonitorTc');
    }

}