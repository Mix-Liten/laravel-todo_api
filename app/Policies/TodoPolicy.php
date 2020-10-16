<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny()
    {
        // if (! $user->tokenCan(PermissionType::PERMISSION_VIEW_ANY)) {
        //     throw new PermissionDeniedException();
        // }

        return true;
    }

    public function create()
    {
        return true;
    }

    public function update(User $user, Todo $todo)
    {
        return $user->id == $todo->user->id;
    }

    public function delete(User $user, Todo $todo)
    {
        return $user->id == $todo->user->id;
    }
}
