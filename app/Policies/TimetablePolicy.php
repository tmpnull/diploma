<?php

namespace App\Policies;

use App\User;
use App\Timetable;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimetablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create timetables.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->authorizeRoles('superadmin');
    }

    /**
     * Determine whether the user can update the timetable.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->authorizeRoles('superadmin');
    }

    /**
     * Determine whether the user can delete the timetable.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->authorizeRoles('superadmin');
    }
}
