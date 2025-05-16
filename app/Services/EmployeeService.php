<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function __construct(
        protected EmployeeRepository $employeeRepository,
        protected TaskRepository $taskRepository
    ) {}

    public function createEmployee(array $data)
    {
        return $this->employeeRepository->create($data);
    }

    public function updateEmployeeTask(int $taskId, int $employeeId, array $data): void
    {
        DB::beginTransaction();

        try {
            $employee = $this->employeeRepository->findByIdAndTask($employeeId, $taskId);
            $task     = $this->taskRepository->findByIdAndEmployee($employeeId, $taskId);

            $newHours     = (int) $data['employee_hours'];
            $newDesc      = $data['task_description'];
            $newExtraCost = (int) ($data['extra_cost'] ?? 0);

            $this->employeeRepository->update($employee, [
                'employee_hours'   => $employee->employee_hours + $newHours,
                'task_description' => $newDesc,
                'extra_cost'       => $employee->extra_cost + $newExtraCost,
            ]);

            $additionalRemuneration = ($newHours * $employee->employee_rate) + $newExtraCost;
            $updatedRemuneration    = $task->total_remuneration + $additionalRemuneration;

            $this->taskRepository->updateById($taskId, [
                'total_remuneration' => $updatedRemuneration,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
