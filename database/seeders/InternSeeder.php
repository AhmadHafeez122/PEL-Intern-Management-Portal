<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Intern;
use App\Models\Department;
use App\Models\Supervisor;

class InternSeeder extends Seeder
{
    public function run(): void
    {
        // Safety check: ensure dependencies exist first
        if (Department::count() === 0) {
            $this->command->error('No departments found! Please seed departments first.');
            return;
        }

        // 1. Create 130 standard / assigned interns
        Intern::factory(130)->create();

        // 2. Create 20 unassigned interns (null department and supervisor)
        Intern::factory()->unassigned()->count(20)->create();

        $this->command->info('Successfully seeded 130 assigned and 20 unassigned interns!');
    }
}
