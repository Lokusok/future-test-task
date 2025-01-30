<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['выполнена', 'не выполнена'];
        $priorities = ['низкий', 'средний', 'высокий'];
        $categories = ['работа', 'дом', 'личное'];

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(rand(5, 25)),
            'due_date' => $this->faker->dateTime(now()->addDays(rand(1, 10))),
            'create_date' => $this->faker->dateTime('now'),
            'status' => $statuses[array_rand($statuses)],
            'priority' => $priorities[array_rand($priorities)],
            'category' => $categories[array_rand($categories)],
        ];
    }
}
