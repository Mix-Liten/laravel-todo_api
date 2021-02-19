<?php

namespace App\Services;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class TodoService
{
    /**
     * @var Todo
     */
    private Todo $todo;

    /**
     * Instantiate a new service instance.
     *
     * @param Todo $todo
     */
    public function __construct(
        Todo $todo
    ) {
        $this->todo = $todo;
    }

    /**
     * @param  User  $user
     * @return Collection  Todo[]
     */
    public function getAllByUser(User $user): Collection
    {
        $todos = $user->todos;
        return $todos;
    }

    /**
     * @param  User  $user
     * @param  Request  $request
     * @return Model|Todo
     */
    public function store(User $user, Request $request): Todo
    {
        /** @var Todo $todo */
        $todo = $user->todos()->create([
            'content' => $request->content,
            'is_completed' => false,
        ]);

        return $todo;
    }

    /**
     * @param  Todo  $todo
     * @param  Request  $request
     * @return Model|Todo
     */
    public function update(Todo $todo, Request $request): Todo
    {
        $todo->update($request->all());

        return $todo;
    }

    /**
     * @param  User  $user
     * @param  Todo  $todo
     * @return bool
     */
    public function destroy(User $user, Todo $todo): bool
    {
        return $user->todos
            ->find($todo->id)
            ->delete();
    }
}
