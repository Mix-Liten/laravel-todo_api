<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource as Resource;
use App\Models\User;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    /**
     * @var TodoService
     */
    private TodoService $todoService;

    /**
     * Instantiate a new controller instance.
     *
     * @param  TodoService  $todoService
     */
    public function __construct(
        TodoService $todoService
    ) {
        // $this->authorizeResource(Todo::class);

        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     * 列表
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $user = Auth::user();
        $todos = $this->todoService->getAllByUser($user);
        
        return Resource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     * 新增
     * @param  TodoStoreRequest  $request
     * @return Resource
     */
    public function store(TodoStoreRequest $request)
    {
        $user = Auth::user();
        $todo = $this->todoService->store($user, $request);

        return new Resource($todo);
    }

    /**
     * Update the specified resource in storage.
     * 更新
     * @param  TodoUpdateRequest  $request
     * @param  Todo  $todo
     * @return Resource
     */
    public function update(TodoUpdateRequest $request, Todo $todo)
    {
        $this->authorize('update', [$todo, $request->input('id')]);
        $todo = $this->todoService->update($todo, $request);

        return new Resource($todo);
    }

    /**
     * Remove the specified resource from storage.
     * 刪除
     * @param  Todo  $todo
     * @return JsonResponse
     */
    public function destroy(Todo $todo)
    {
        $this->authorize('delete', [$todo]);

        $user = Auth::user();
        
        $this->todoService->destroy($user, $todo);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
