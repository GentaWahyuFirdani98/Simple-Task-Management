<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample users
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Create sample tasks
        DB::table('tasks')->insert([
            [
                'title' => 'Setup Project Environment',
                'description' => 'Configure development environment and install dependencies',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-01-15',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Design Database Schema',
                'description' => 'Create database tables and relationships for the application',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => '2024-01-20',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Implement User Authentication',
                'description' => 'Create login and registration functionality',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-01-25',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Create Task Management Interface',
                'description' => 'Build UI for creating, editing, and managing tasks',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-02-01',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Write Documentation',
                'description' => 'Create user manual and technical documentation',
                'status' => 'pending',
                'priority' => 'low',
                'due_date' => '2024-02-10',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
