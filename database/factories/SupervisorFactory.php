<?php

namespace Database\Factories;

use App\Models\Supervisor;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupervisorFactory extends Factory
{
    protected $model = Supervisor::class;

    public function definition(): array
    {
        return [
            // Grab a random existing department instead of creating a new one
            'department_id' => Department::inRandomOrder()->first()->id ?? 1,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'is_active' => fake()->boolean(90),
        ];
    }
}
