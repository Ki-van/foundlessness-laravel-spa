<?php

namespace App\Policies;

use App\Models\Mark;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MarkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, Mark $mark)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create marks');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Mark $mark)
    {
        return $user->hasPermissionTo('update marks') && $mark->user_id = $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Mark $mark)
    {
        return $user->hasPermissionTo('delete marks');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Mark $mark)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Mark $mark)
    {
        //
    }
}
