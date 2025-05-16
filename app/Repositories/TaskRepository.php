<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function existsTaskForEmployee(string $taskName, string $employeeName): bool
    {
        return Task::where('task_name', $taskName)
            ->whereHas('employees', fn ($q) => $q->where('employee_name', $employeeName))
            ->exists();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Task::where('id', $id)->update($data);
    }

    public function find(int $id): ?Task
    {
        return Task::with('employees')->find($id);
    }

    public function findById(int $taskId): Task
    {
        return Task::findOrFail($taskId);
    }

    public function findByName(string $taskName): ?Task
    {
        return Task::where('task_name', $taskName)->first();
    }

    public function paginate($perPage)
    {
        return Task::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findByIdAndEmployee(int $employeeId, int $taskId): Task
    {
        return Task::where('id', $taskId)
            ->whereHas('employees', fn ($query) => $query->where('employee_id', $employeeId))
            ->firstOrFail();
    }

    public function updateById(int $taskId, array $data): bool
    {
        $task = $this->findById($taskId);
        return $task->update($data);
    }
}
