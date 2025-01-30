<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_task_index(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'description',
                'due_date',
                'create_date',
                'priority',
                'category',
                'status'
            ]
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_task_show(): void
    {
        $taskId = 1;

        $response = $this->get(route('tasks.show', [$taskId]));

        $response->assertJsonStructure([
            'id',
            'title',
            'description',
            'due_date',
            'create_date',
            'priority',
            'category',
            'status'
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_task_show_throw_404(): void
    {
        $taskId = PHP_INT_MAX;

        $response = $this->get(route('tasks.show', [$taskId]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_task_store()
    {
        $postData = [
            'title' => 'Title of task',
            'description' => 'Description will be here',
            'due_date' => '2025-01-20T15:00:00',
            'create_date' => '2025-01-20T15:00:00',
            'priority' => 'высокий',
            'category' => 'Дом',
            'status' => 'не выполнена'
        ];

        $response = $this->post(route('tasks.store'), $postData);

        $json = $response->json();

        $task = Task::find($json['id']);

        $this->assertNotNull($task);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_task_update()
    {
        $taskId = 1;
        $newTask = [
            "title" => "Title of task _update",
            "description" => "Description will be here _update",
            "due_date" => "2025-01-20T22:00:00",
            "create_date" => "2025-01-20T22:00:00",
            "priority" => "низкий",
            "category" => "Отдых",
            "status" => "не выполнена",
        ];

        $response = $this->put(route('tasks.update', [$taskId]), $newTask);

        $response->assertJsonStructure([
            'message',
        ]);

        $task = Task::find($taskId);

        $this->assertEquals($task->title, $newTask['title']);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_task_delete()
    {
        $taskId = 1;

        $response = $this->delete(route('tasks.destroy', [$taskId]));

        $task = Task::find($taskId);

        $this->assertNull($task);

        $response->assertStatus(Response::HTTP_OK);
    }
}
