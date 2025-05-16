<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return response()->json($this->taskService->paginate($perPage));
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $result = $this->taskService->createTask($validated);

        if (isset($result['error'])) {
            return response()->json([
                'success' => false,
                'message' => $result['error'],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'task' => $result['task'],
        ], 201);
    }

    public function destroy(string $id)
    {
        try {
            $this->taskService->softDelete($id);
            return response()->json(['message' => 'Task soft deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function getEmployees(string $id)
    {
        try {
            $task = $this->taskService->getEmployeesByTaskId($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            return response()->json([
                'task_name' => $task->task_name,
                'task_date' => $task->task_date,
                'employees' => $task->employees->map(fn ($employee) => [
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->employee_name,
                    'task_description' => $employee->task_description,
                    'employee_hours' => $employee->employee_hours,
                    'employee_rate' => $employee->employee_rate,
                    'extra_cost' => $employee->extra_cost,
                    'remuneration' => ($employee->employee_hours * $employee->employee_rate) + $employee->extra_cost,
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
