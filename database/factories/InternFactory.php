<?php

namespace Database\Factories;

use App\Models\Intern;
use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternFactory extends Factory
{
    protected $model = Intern::class;

    public function definition(): array
    {
        $department = Department::inRandomOrder()->first();
        $supervisor = Supervisor::where('department_id', $department?->id)->inRandomOrder()->first();

        return [
            'department_id' => $department?->id ?? 1,
            'supervisor_id' => $supervisor?->id ?? null,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'university' => fake()->randomElement(['UET Lahore', 'LUMS', 'NUST', 'FAST NUCES', 'Punjab University']),
            'registration_number' => 'PEL-' . fake()->unique()->numerify('####'),
            'status' => fake()->randomElement(['Pending', 'Active', 'Active', 'Completed', 'Rejected']),
        ];
    }

    /**
     * Define a state specifically for unassigned interns (null department and supervisor).
     */
    public function unassigned(): static
    {
        return $this->state(fn (array $attributes) => [
            'department_id' => null,
            'supervisor_id' => null,
        ]);
    }
}
