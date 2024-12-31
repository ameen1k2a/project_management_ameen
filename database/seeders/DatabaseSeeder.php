<?php

namespace Database\Seeders;


// Seeder for Projects and Tasks
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Projects
        $projects = [
            ['name' => 'Project 1', 'status' => 'Active'],
            ['name' => 'Project 2', 'status' => 'Inactive'],
            ['name' => 'Project 3', 'status' => 'Active'],
            ['name' => 'Project 4', 'status' => 'Active'],
            ['name' => 'Project 5', 'status' => 'Active'],
        ];

        foreach ($projects as $project) {
            DB::table('projects')->insert($project);
        }

        // Seed Tasks
        $tasks = [
            ['project_id' => 1, 'name' => 'Task 1', 'status' => 'Active'],
            ['project_id' => 1, 'name' => 'Task 2', 'status' => 'Active'],
            ['project_id' => 1, 'name' => 'Task 3', 'status' => 'Active'],
            ['project_id' => 4, 'name' => 'Task 4', 'status' => 'Active'],
            ['project_id' => 4, 'name' => 'Task 5', 'status' => 'Active'],
        ];

        foreach ($tasks as $task) {
            DB::table('tasks')->insert($task);
        }

        // Seed Time Entries
        $timeEntries = [
            [ 'task_id' => 1, 'hours' => 2, 'date' => '2021-02-02', 'description' => 'DB creation'],
            [ 'task_id' => 1, 'hours' => 6, 'date' => '2021-02-25', 'description' => 'Bug fixing'],
            [ 'task_id' => 2, 'hours' => 3, 'date' => '2021-03-28', 'description' => 'Testing'],
            ['task_id' => 4, 'hours' => 6, 'date' => '2020-03-03', 'description' => 'User Manager'],
            ['task_id' => 4, 'hours' => 4, 'date' => '2021-04-02', 'description' => 'Billing calculation'],
            ['task_id' => 5, 'hours' => 8, 'date' => '2020-05-07', 'description' => 'Login and Logout'],
        ];

        foreach ($timeEntries as $entry) {
            DB::table('time_entries')->insert($entry);
        }
    }
}
