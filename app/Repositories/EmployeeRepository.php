<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data): void
    {
        $employee->update($data);
    }

    public function delete(int $id): bool
    {
        return Employee::destroy($id) > 0;
    }

    public function findByIdAndTask(int $employeeId, int $taskId): Employee
    {
        return Employee::where('id', $employeeId)
            ->whereHas('tasks', fn($query) => $query->where('task_id', $taskId))
            ->firstOrFail();
    }
}
