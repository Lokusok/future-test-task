<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class TaskController extends Controller
{
    #[OA\Get(
        path: '/api/tasks',
        tags: ['Tasks'],
        summary: 'Get a list of tasks',
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                description: 'Page of the results',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'search',
                in: 'query',
                description: 'Search by title',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'sort',
                in: 'query',
                description: 'Field to sort by',
                required: false,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of tasks',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'id', type: 'integer'),
                            new OA\Property(property: 'title', type: 'string'),
                            new OA\Property(property: 'description', type: 'string'),
                            new OA\Property(property: 'due_date', type: 'string'),
                            new OA\Property(property: 'create_date', type: 'string'),
                            new OA\Property(property: 'priority', type: 'string'),
                            new OA\Property(property: 'category', type: 'string'),
                            new OA\Property(property: 'status', type: 'string'),
                        ]
                    )
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $tasks = Task::query()
            ->ofSearch($request->input('search'))
            ->ofSort($request->input('sort'))
            ->paginate(10);

        return TaskResource::collection($tasks)->resolve();
    }

    #[OA\Post(
        path: '/api/tasks',
        tags: ['Tasks'],
        summary: 'Create a new task',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'due_date', type: 'string'),
                    new OA\Property(property: 'create_date', type: 'string'),
                    new OA\Property(property: 'priority', type: 'string'),
                    new OA\Property(property: 'category', type: 'string'),
                    new OA\Property(property: 'status', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Task created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            )
        ]
    )]
    public function store(TaskStoreRequest $request)
    {
        $task = Task::create($request->validated());

        return response()->json([
            'id' => $task->id,
            'message' => __('Task created successfully')
        ], Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: '/api/tasks/{id}',
        tags: ['Tasks'],
        summary: 'Get single task',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'task ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Info about single task',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'description', type: 'string'),
                        new OA\Property(property: 'due_date', type: 'string'),
                        new OA\Property(property: 'create_date', type: 'string'),
                        new OA\Property(property: 'priority', type: 'string'),
                        new OA\Property(property: 'category', type: 'string'),
                        new OA\Property(property: 'status', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Task not found'
            )
        ]
    )]
    public function show(Task $task)
    {
        return TaskResource::make($task)->resolve();
    }

    #[OA\Put(
        path: '/api/tasks/{id}',
        tags: ['Tasks'],
        summary: 'Update task',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Task ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'due_date', type: 'string'),
                    new OA\Property(property: 'create_date', type: 'string'),
                    new OA\Property(property: 'priority', type: 'string'),
                    new OA\Property(property: 'category', type: 'string'),
                    new OA\Property(property: 'status', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Task updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Task not found',
            )
        ]
    )]
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'message' => __('Task updated successfully'),
        ], Response::HTTP_OK);
    }

    #[OA\Delete(
        path: '/api/tasks/{id}',
        tags: ['Tasks'],
        summary: 'Delete task',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Task ID',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Task deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Task not found',
            )
        ]
    )]
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => __('Task deleted successfully')
        ], Response::HTTP_OK);
    }
}
