<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query()
            ->ofSearch($request->input('search'))
            ->ofSort($request->input('sort'))
            ->paginate(10);

        return TaskResource::collection($tasks)->resolve();
    }

    public function store(TaskStoreRequest $request)
    {
        $task = Task::create($request->validated);

        return response()->json([
            'id' => $task->id,
            'message' => __('Task created successfully')
        ], Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        return TaskResource::make($task)->resolve();
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'message' => __('Task updated successfully'),
        ], Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => __('Task deleted successfully')
        ], Response::HTTP_OK);
    }
}
