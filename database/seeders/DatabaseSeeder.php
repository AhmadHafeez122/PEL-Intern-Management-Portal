<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\InternSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::firstOrCreate(
            ['email' => 'admin@pel.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'), // Default password
                'role' => 'admin',
            ]
        );

        // 2. Safely create Departments
        $departments = ['Engineering', 'Marketing', 'IT & Software', 'HR Dept'];
        foreach ($departments as $deptName) {
            Department::firstOrCreate(['name' => $deptName]);
        }

        // 3. Create Supervisors (if none exist)
        if (Supervisor::count() === 0) {
            Supervisor::factory(24)->create(function () {
                return ['department_id' => Department::inRandomOrder()->first()->id];
            });
        }

        // 4. Force the InternSeeder to run
        $this->call([
            InternSeeder::class,
        ]);
    }
}
