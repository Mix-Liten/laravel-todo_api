<?php

namespace App\Services;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
     * @param  Todo  $todo
     * @return Model|Todo
     */
    public function getAllByUser(User $user)
    {
        $todos = $this->todo->where('created_by', $user->id)->get();
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
        $todo = new Todo;
        $todo->content = $request->content;
        $todo->is_complete = false;
        $todo->created_by = $user->id;
        $todo->save();

        return $todo;
    }

    /**
     * @param  Todo  $todo
     * @param  Request  $request
     * @return Model|Todo
     */
    public function update(Todo $todo, Request $request): Todo
    {
        $todo->update([
            'content' => $request->content,
            'is_complete' => $request->is_complete,
        ]);

        return $todo;
    }

    /**
     * @param  User  $user
     * @param  Todo  $todo
     * @return bool
     */
    public function destroy(User $user, Todo $todo): bool
    {
        return $this->todo::where('created_by', $user->id)
            ->find($todo->id)
            ->delete();
    }
}
