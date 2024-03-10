<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskStoreRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Auth::user()->tasks()->paginate(100));
    }

    public function store(TaskStoreRequest $request): TaskResource
    {
        $task = Auth::user()->tasks()->create($request->validated());

        return new TaskResource($task);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(TaskStoreRequest $request, Task $task): TaskResource
    {
        $task->update($request->validated());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
