<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepository,
        protected EmployeeService $employeeService
    ) {}

    public function createTask(array $data): array
    {
        if ($this->taskAlreadyAssigned($data['task_name'], $data['employee_name'])) {
            return ['error' => $data['employee_name'] . ' sudah mengambil tugas ini.'];
        }

        DB::beginTransaction();

        try {
            $task = $this->getOrCreateTask($data);
            $employee = $this->createEmployee($data, $task);
            $this->updateTaskRemuneration($task, $employee);

            DB::commit();

            return ['task' => $task->fresh('employees')];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function paginate($perPage)
    {
        return $this->taskRepository->paginate($perPage);
    }

    public function softDelete(string $id): void
    {
        $task = $this->taskRepository->find($id);

        if (!$task) {
            throw new \Exception('Task not found');
        }

        $task->delete(); // SoftDeletes trait
    }

    public function getEmployeesByTaskId(string $id)
    {
        return $this->taskRepository->find($id);
    }

    private function taskAlreadyAssigned(string $taskName, string $employeeName): bool
    {
        return $this->taskRepository->existsTaskForEmployee($taskName, $employeeName);
    }

    private function getOrCreateTask(array $data)
    {
        return $this->taskRepository->findByName($data['task_name']) ??
            $this->taskRepository->create([
                'task_name' => $data['task_name'],
                'task_date' => Carbon::parse($data['task_date'])->format('Y-m-d'),
                'total_remuneration' => 0,
            ]);
    }

    private function createEmployee(array $data, $task)
    {
        $employee = $this->employeeService->createEmployee([
            'employee_name'    => $data['employee_name'],
            'employee_hours'   => $data['employee_hours'],
            'employee_rate'    => $data['employee_rate'],
            'extra_cost'       => $data['extra_cost'] ?? 0,
            'task_description' => $data['task_description'],
        ]);

        if (! $task->employees()->where('employee_id', $employee->id)->exists()) {
            $task->employees()->attach($employee->id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $employee;
    }

    private function updateTaskRemuneration($task, $employee): void
    {
        $currentRemuneration = $this->getCurrentRemuneration($task->id);
        $additionalRemuneration = $this->calculateRemuneration($employee);

        $updatedTotal = $currentRemuneration + $additionalRemuneration;

        $this->taskRepository->update($task->id, [
            'total_remuneration' => $updatedTotal,
        ]);
    }

/**
 * Get current total remuneration from the database.
 *
 * @param int $taskId
 * @return float
 */
    private function getCurrentRemuneration(int $taskId): float
    {
        $task = $this->taskRepository->findById($taskId);
        return (float) $task->total_remuneration;
    }

/**
 * Calculate the remuneration for a given employee.
 *
 * @param \App\Models\Employee $employee
 * @return float
 */
    private function calculateRemuneration($employee): float
    {
        return ($employee->employee_hours * $employee->employee_rate) + $employee->extra_cost;
    }   
}
