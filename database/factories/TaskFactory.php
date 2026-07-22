<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Intern;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'intern_id' => Intern::inRandomOrder()->first()?->id ?? 1,
            'status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed']),
        ];
    }
}
