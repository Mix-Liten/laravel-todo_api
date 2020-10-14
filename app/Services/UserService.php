<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserService
{
    /**
     * @var User
     */
    private User $user;

    /**
     * Instantiate a new service instance.
     *
     * @param  User  $user
     */
    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * @param  Request  $request
     * @return Model|User
     */
    public function store(Request $request): User
    {
        return $this->user->query()->create($request->all());
    }
}