<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::factory(30)->create()->each(function ($task) {
            $employees = Employee::inRandomOrder()->take(rand(2, 5))->get();

            $total = 0;
            foreach ($employees as $employee) {
                $remun = ($employee->employee_hours * $employee->employee_rate) + $employee->extra_cost;
                $total += $remun;
            }

            $task->employees()->attach($employees->pluck('id'));
            $task->update(['total_remuneration' => $total]);
        });
    }
}
